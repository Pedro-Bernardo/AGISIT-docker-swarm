# Instructions

## Build the container
``` 
docker build . --tag=web_container
```
## Run the container
Mount has to be done at runtime, Dockerfiles don't support it for security reasons
```
docker run -d -p 80:80 --mount type=bind,source=/path/to/sharedfs,target=/storage --env UPLOAD_DIR=/storage/ web_container
```
## Access localhost:80