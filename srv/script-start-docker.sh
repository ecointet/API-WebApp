docker kill $(docker ps -qf expose=8080)
docker build -t ecointet/api-webapp . && docker run -p 8080:8080 -d -e PORT=8080 ecointet/api-webapp
