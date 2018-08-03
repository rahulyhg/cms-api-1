FROM node:latest

MAINTAINER "Shahrokh Nabavi <info@nabavi.nl>"
LABEL Version="1.0" \
      Author="Shahrokh" \
      Maintainer="Shahrokh Nabavi <info@nabavi.nl>"


RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb http://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y git yarn \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*