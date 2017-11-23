# FACET Post Award

[![Build Status](https://travis-ci.org/facet-acq/post-award.svg?branch=develop)](https://travis-ci.org/facet-acq/post-award)
[![Known Vulnerabilities](https://snyk.io/test/github/facet-acq/post-award/badge.svg)](https://snyk.io/test/github/facet-acq/post-award)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d715c190ecd1406d8f91ddf9e7864d2c)](https://www.codacy.com/app/djfurman/post-award?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=facet-acq/post-award&amp;utm_campaign=Badge_Grade)

[FACET-Acq](https://github.com/facet-acq/) is Federation of Administration and Contract Entitlement Transactions for Acquisitions. This service is designed to manage the 'post-award' portion of the Procurement-to-Payment business process.

## Scope

This scope includes all elements from the point of award of an agreement or contract through the fulfillment of that agreement, payment of resulting invoices and closeout of the agreement.

## Purpose

In line with the [FACET-Acq](https://github.com/facet-acq/) vision, this service will fill the entitlement and administration need of any large organization desiring an open source alternative to costly monolithic systems.

## Contributing

Contributions are welcome from both technical and business minded individuals, please [review our wiki](https://github.com/facet-acq/post-award/wiki#contributing) and join us!

## Deployment Plan

![amazon web services resilient deployment concept](DeployingPostAward.png)

## Installation

### Development

In development? Great! There are a few options. I personally like the tiered approach.

| Environment | System |
| :--- | :--- |
| Local | Mac/Linux |
| CI | Travis |
| Testing | Docker |
| Production | Docker |

#### IDE and Editors

For an editor, I've recently been leveraging Visual Studio Code a free NodeJS based code editor which provides an excellent feature set and strong extensions for working with PHP and VueJS. As a charting tool, I leverage draw.io desktop.

#### Local

Locally I run the following on my Mac/Linux development environments:

- Zsh
- Git
- Php
- NodeJS
- Laravel Valet
- PostgreSQL
- Redis

While not the most automated setup (with the exception of Valet), I am quite comfortable with these from years of system work. I think the learning opportunities are valuable from working with the software on a more direct level.
