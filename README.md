# Quebble

## Concept

Programmatically get the upcoming workdays as JSON of an employee working at a company using Quebble.

## Requirements

- PHP ^7.4

## Installation

### Docker

Recommended installation is by using the provider Dockerfile. 

#### Build
`docker build -t quebble .`

#### Run
`docker run -d -p 1337:80 -e USERNAME="your@email.com" -e PASSWORD="yourpassword" --name quebble quebble`

## Disclaimer

You can use this software as-is without any warranty.
You are responsible for securing your devices and software yourself.
