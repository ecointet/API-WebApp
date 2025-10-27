docker-compose down
docker kill api-webapp
docker rm /api-webapp
docker build -t ecointet/api-webapp .
docker-compose up
#docker build -t ecointet/api-webapp . && docker run -p 8080:8080 -d -e GKEY=AIzaSyA8VWh_40pd430228DP72uZSR6X63eSOu4 -e PORT=8080 --name "api-webapp" --mount source=api-webapp,target=/data ecointet/api-webapp
#docker build -t ecointet/api-webapp . && docker run -p 8080:8080 -d -e DB_TYPE=FILE -e GKEY=AIzaSyA8VWh_40pd430228DP72uZSR6X63eSOu4 -e PORT=8080 --name "api-webapp" --mount source=api-webapp,target=/data ecointet/api-webapp