# Timeline 

## 18/04/23

- Made this for SAL so figured I might as well make it again for GP helper
- Note that we save json to the cache folder - the json filename is dependent on the timeline title and page id
- We only create the cache file if the page modified timestamp is different to the file modified one...
- So if you change the timeline title, things may go weird. If this happens, just delete the cache file and it'll recreate it

