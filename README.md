# Take Home exercise for Riot

Install the project:
```
docker compose up -d
```

Run the tests:
```
docker compose exec php bin/phpunit
```

Call the endpoints:
```
# Encrypt
curl -k -X POST -H "Content-Type: application/json" https://localhost/encrypt -d '{"tomtom": "nana"}'
# Decrypt
curl -k -X POST -H "Content-Type: application/json" https://localhost/decrypt -d '{"tomtom": "bmFuYQ=="}'
# Sign
curl -k -X POST -H "Content-Type: application/json" https://localhost/sign -d '{"tomtom": "bmFl","t":"a"}'
# Verify
curl -k -v -X POST -H "Content-Type: application/json" https://localhost/verify -d '{"signature":"d9c2ec63297661767376b0eef516733522dd5685690b7414e1554b639484f834","data":{"tomtom": "bmFl","t":"a"}}'
```
