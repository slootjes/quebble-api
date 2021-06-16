# Quebble

## Project

Programmatically get the planning as JSON of an employee working at a company using Quebble.
The goal of this tool is to load the results in Home Assistant so someone can be notified when there are changes made in the planning.

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

I am not affiliated with Quebble nor is this software endorsed by Quebble.
You can use this software as-is without any warranty.
You are responsible for securing your devices and software yourself.
