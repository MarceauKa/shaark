# Shaark - Docker deployment
Docker can be used to deploy Shaark.  
By default it will install Shaark in production mode.  
This behaviour can be changed by editing the Dockefile.  

## Installation

### Requirements
At the moment the application needs to be in HTTPS since some srcs are in https (eg. js files) even if the site is in plain HTTP.  
This should not be an issue if you already run some kind of reverse proxy, otherwise, you will need to run one and use a certificate (a self-signed one will be fine).  
**NOTE**: you may (probably) need to customize the dockerfile (e.g. changing the network the container is attached at) to suit your case. (At least until the application will use HTTPS links)  

### Quick Run
You can try the application in minutes by running those commands:
```
git clone https://github.com/MarceauKa/shaark
cd shaark
docker-compose up -d .
```
And then running a reverse proxy like NGINX on the `nginx_net`.  
If you don't already have a reverse proxy, you can google on how to create one.
