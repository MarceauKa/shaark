const CACHE = "shaarli";
const offlineFallbackPage = "offline";
const avoidCachingPaths = [
    /chest\/.*/,
];

self.addEventListener("install", function (event) {
    event.waitUntil(
        caches
            .open(CACHE)
            .then(function (cache) {
                return cache.add(offlineFallbackPage);
            })
    );
});

self.addEventListener("fetch", function (event) {
    if (event.request.method !== "GET"
        && event.request.url.substr(0, 4) !== 'http') {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then(function (response) {
                event.waitUntil(updateCache(event.request, response.clone()));
                return response;
            })
            .catch(function (error) {
                return fromCache(event.request);
            })
    );
});

function pathComparer(requestUrl, pathRegEx) {
    return requestUrl.match(new RegExp(pathRegEx)) !== null;
}

function comparePaths(requestUrl, pathsArray) {
    if (requestUrl) {
        for (let index = 0; index < pathsArray.length; index++) {
            const pathRegEx = pathsArray[index];
            if (pathComparer(requestUrl, pathRegEx)) {
                return true;
            }
        }
    }

    return false;
}

function fromCache(request) {
    return caches
        .open(CACHE)
        .then(function (cache) {
            return cache
                .match(request)
                .then(function (matching) {
                    if (! matching || matching.status === 404) {
                        return Promise.reject("no-match");
                    }

                    return matching;
                });
        });
}

function updateCache(request, response) {
    if (! comparePaths(request.url, avoidCachingPaths)) {
        return caches
            .open(CACHE)
            .then(function (cache) {
                return cache.put(request, response);
            });
    }

    return Promise.resolve();
}
