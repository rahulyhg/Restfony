#:tw-2668: Restfony 
Simple REST interface built on Synfony 4.2

------------

###Features
Feature  | 
------------- | -------------
RESTfull API  | :fa-check:
JSON Response  |  :fa-check:
HTTP Status  |  :fa-check:
Exception Handling |  :fa-check:
Doctrine ORM |  :fa-check:

###Installation
Download or Clone this repo
`git clone https://github.com/shuhailshuvo/Restfony.git`

Install Dependency
`composer install`

Configure Databse in `.env` file
`DATABASE_URL="mysql://root:@127.0.0.1:3306/restfony"`

Database Migration
`php bin/console doctrine: migrations: migrate`

Run the API service
`php bin/console server:run`

Download the Postman Collection
[![Download](data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDRcMGR0XFRAWIB0XGB0dGxwvKCgiHR4xHR8VNTElJSkrLi4uFyUzODUtNyg5Li0BCgoKDg0OGhAPGDclICUtLjc3KzctNy4rLSs3Ky0tLS0tLjctLS0tLS0rLS0rLS03Ky0tKy0tLTcrLS0tLS0tLf/AABEIAB4AZAMBEQACEQEDEQH/xAAaAAACAwEBAAAAAAAAAAAAAAAAAwECBAUH/8QALBAAAgIBAwMCBQQDAAAAAAAAAQIDBAAREhQFIVExQRMiQmGRcoGh0SMkcf/EABoBAQADAQEBAAAAAAAAAAAAAAACAwQFAQb/xAArEQACAgIABgEDAwUAAAAAAAABAgADERMEEiExQVFxFGGRIjKBBSOxwdH/2gAMAwEAAhEDEQA/APRTa7nvnC2z5ndDlDzjbG6HKHnG2N0OUPONsbocr742xuhyh5xtjdI5Q842/eDd95PKHnBtjdDlffG2N0OUPONsbocoecbY3Q5Q842xukraGnrnu2ei6YuiCO1ckWZd6pEzaH300yjggtlpDDxmZv6dyW2kOM4BjY2r36FmSGAV5oND8pJVgckpruqdlXBX8SaGriKXZV5WX12Il7s1PpllKslYTHaplZide/jJWvVQ4rKZ9n59SfEWUcLYKmTPbJz79Rs1GNRdgg1aWMJJH5Cn2yx+HUCyte/Qj4Mts4VQLa06kYI94Me/T68lqutdQUjcx2P+gA5a3D1tYvKOxwfxmXNwlTWIEHQHDfwMxMVWtb6duh0jnkkf4Ovvpr2/GVrVXbTlehJOP+fiUpRVdRlOjEtj+PH4k1qsTWaMcsR+euzuD7sM9rpXnrVh3U/mSppQ2VKy91JPzORR/wBq/FXLaB30/bvnPp/uWivPmcrhxtuWvPczoxT0ZupHp/E2ruKK+p3Aj3zYtlD2mnk+2fM6CWcPZf8AT8mPAPnMp0+CNZLU1tTJDA/w+31HX+s84etQztZ1A6SPCVKrWPaMqvT5MvBUWPrUtWdd8ao0ia+49sklIXiWrYdMZkq+HCcW1TjIAJ/iLietfpWnigFeWBd/yEkMMrRqranKrgr6laNTxFTsqcpUZ+xE5iWSR2JzALTOYLpr6e70bDSpGr7lKkN4zTQxpfmAzNnCs3D2FwM56YjJbBNV61etHXjkOr7NdW/OWPbmsoq8oMse4mo11oFB747mN5m/4bWqcU80Q0Vjr/PnJ/UZALoCR5ln1PNymysMR5la92zD1B7rAO7jQg+mRrvsSw2kZJ8SNXFWpebiMk9MSta5Yrx2lChuQSTr9JOueV32Vhxj908q4m2tbAB+7/MUXlFSCug2mFy6sPXXK+ZtaoB2OcynnfUlY6cpznzNj9TsPchsmFN8aFP1a+uaTxbmxX5ewmw8da1q28oyBj5mZ5E3LJXpxwSq24MpY5QXGQyJgjz1mYuMhkrCkHvkx/O2ytYjpQrZb1fv+dPTLhxOGLiv9XuX/V4Y2LWA/v8A36iRbtJVSCFjFoxZ2Q93J85VusCBF6ff2ZT9RctYRDy9TkjzmOTqE4lhleJJJI4zGS31g+csHEvzKxGSBj5lo4ywMrsuSBjPsfeKknJrPBWqx10kP+TZqS2Qa39BREABlb3E1mutAoPf2ZjSqQPTMwqmMUTsmuv2zoGudU1CHGXPdcahDjLjXGoQ4y41xqEOMuNcahDjLjXGoQ4y41xqEOMuNcahDjLjXGoQ4y41xqEOMuNcahDjLjXGoSVrrp7YCSQrE//Z)](https://www.getpostman.com/collections/4139657aad11d5e1e753 "Download")


###TODO
Feature  | 
------------- | -------------
Custom Validator  | :fa-minus:
Custom Exception Handler  |   :fa-minus:
Functional Testing | :fa-minus:
JWT |  :fa-minus:
CORS |  :fa-minus:
