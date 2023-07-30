# API-WEBAPP
A cool reponsive Web App, made to illustrate APIs.

![image](https://raw.githubusercontent.com/ecointet/API-WebApp/main/images/screen-app.png)

## ONLINE USAGE
- URL: [https://app.cointet.com](url)

### Dedicated Instance for a Prospect
- URL: [https://app.cointet.com/](url)**PROSPECT**
- Exemple: [*https://app.cointet.com/mercedes*](url)

## LOCAL USAGE
### STEP 1
`git clone https://github.com/ecointet/API-WebApp.git`

`cd API-WebApp`

### STEP 2
`docker build -t ecointet/api-webapp .`

***If successful, run the docker image just created with your Google Map API (ask for it):***

`docker run -p 8080:8080 -e DB_TYPE=FILE -e GKEY=<GoogleAPI> -e PORT=8080 ecointet/api-webapp`

### STEP 3
Open a browser and go to [http://localhost:8080](url)

# HOW TO USE IT

Put the API URL you want to use in this form :
![image](https://raw.githubusercontent.com/ecointet/API-WebApp/main/images/screen-formapi.png)

In case of a mock server url, nothing will be replaced.
Otherwise if nothing is specified after /locate/, the visitor IP will be inserted.

## POSTMAN COLLECTION
Supported End-Point : /locate/<IP>
JSON variable: city, desc, photo

## Customize it!
- Menu > Configuration
- Paste any img url or leave it empty to generate new images.
