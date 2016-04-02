APP_NAME=blue-apron-weekly

echo "Building $APP_NAME image"
docker build -t $APP_NAME .

echo "Removing $APP_NAME container if it exists"
docker rm -f $APP_NAME

echo "Running $APP_NAME container"
docker run -d --name $APP_NAME -h $APP_NAME -p 80:80 -p 443:443 \
    -v ${PWD}/www:/var/www/html \
    $APP_NAME