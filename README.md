### Overview
Currently, Magento 2 does not provide the REST API for the Reviews Extension of the products. 
This module implement WebAPI for product reviews (partially)

Module allow:
- Get one review 
- Create review (without ratings)
- Update review (without ratings)
- Search reviews
- Get product reviews

| Resource | Request method | Description |
| ------------- | ------------- | ------------- | 
| /V1/reviews/:id | GET | Get one review |
| /V1/reviews/:id | PUT | Update review |
| /V1/reviews/:id | DELETE | Delete review |
| /V1/reviews/ | POST | Create review |
| /V1/reviews/ | GET |  Search reviews |
| /V1/products/:sku/reviews | GET | Get product reviews |

### Install

To install this module please use composer dependency manager. In Your Magento2 folder please do execute:

```bash
composer config repositories.divante-review vcs https://github.com/DivanteLtd/magento2-review-api.git
composer require divante/magento2-review-api:dev-master
php bin/magento setup:upgrade 
```

### Compatibility
Module was tested on Magento 2.2.0

### TODO
Create/Save full review (with ratings)
