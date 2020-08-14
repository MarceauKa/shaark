#!/bin/bash

# docker-compose.*.yml files names and their position compared to this script.
# Here: in parent directory.
target_dir="${0%/*}/.."
override_link='docker-compose.override.yml'
override_file_dev='docker-compose.override.dev.yml'


# Get the current environment and tells what are the options
function show_current {
    get_current
    say_switch
}


# Get the current environment
# Output variable: current_env
function get_current {
    if [ -L ${override_link} ]
    then
        # Check for Mac OSX 
        if [[ "$OSTYPE" == "darwin"* ]]; then
            # readlink is not native to mac, so this will work in it's place.
            symlink=$(python3 -c "import os; print(os.path.realpath('docker-compose.override.yml'))")
        else
            # Maintain the cleaner way
            symlink=$(readlink -f docker-compose.override.yml)
        fi
        current_env=$(expr $(basename symlink) : "^docker-compose.override.\(.*\).yml$")
    else
        current_env=production
    fi
}

# Tell to which environments we can switch
function say_switch {
    echo "Using '${current_env}' configuration."
    for one_env in dev production
    do
        if [ "${current_env}" != ${one_env} ]; then
            echo "-> You can switch to '${one_env}' with '${0} ${one_env}'"
        fi
    done
}


function set_production {
    get_current
    if [ "${current_env}" != production ]
    then
        # In production configuration there is no override file
        rm ${override_link}
        docker-compose down
        echo "Now using 'production' configuration."
    else
        echo "Already using 'production' configuration."
    fi
}


function set_dev {
    get_current
    if [ "${current_env}" != dev ]
    then
        rm -f ${override_link}
        ln -s ${override_file_dev} ${override_link}
        docker-compose down
        echo "Now using 'dev' configuration."
    else
        echo "Already using 'dev' configuration."
    fi
}

# Change directory to allow working with relative paths.
cd ${target_dir}

if [ ${#} -eq 1 ] && [[ 'dev production' =~ "${1}" ]]
then
    set_"${1}"
else
    show_current
fi
