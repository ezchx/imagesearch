# imagesearch

Free Code Camp Image Search project

The user enters search parameters at the end of the url. The program then sends a query to the Google custom search API and returns a JSON array of image URLs, image descriptions, and website link urls.

Entering "latest" at the end of url returns the last 5 search terms with timestamps.

Entering an offset (?offset="value") after the search string enables the user to skip the first (offset #) of search items for pagination.

The code is PHP and MySQL.
