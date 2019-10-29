# Shaarli - Archiving

- [PDF Archiving](#pdf-archiving)
- [Media Archiving](#media-archiving)
- [Caveats](#caveats)

## PDF Archiving

PDF archiving is used to backup your links as a PDF using printing functionnality of Chromium.  
We use [Puppeteer](https://github.com/GoogleChrome/puppeteer) to achieve it.

### Installation

Puppeteer is installed as a Composer dependencies but needs Node dependencies that can be installed with:
`npm install @nesk/puphpeteer --no-save`

### Configuration

Once your app is installed, access the **Settings** section, enable **PDF archiving** then configure your **Node path** (defaults to `/usr/bin/node`).
You can use the **Check** button to test your configuration.

## Media Archiving

Media archiving is used to get original media file from Youtube, Soundcloud and [many more](http://ytdl-org.github.io/youtube-dl/supportedsites.html) using [youtube-dl](https://github.com/ytdl-org/youtube-dl/).

### Installation

You need to install manually [youtube-dl](https://github.com/ytdl-org/youtube-dl/#installation) and have access to Python on your system.

### Configuration

Once your app is installed, access the **Settings** section, enable **Media archiving** then configure your **Youtube-dl path** (defaults to `/usr/bin/youtube-dl`).
You can use the **Check** button to test your configuration.

## Caveats

Archiving is performance expensive and should be run in production using queues. See our [installation configuration](https://github.com/MarceauKa/laravel-shaarli/blob/dev/documentation/installation.md) to learn more about it.
