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

### Compatibility
Module was tested on Magento 2.2.5

### TODO
Create/Save full review (with ratings)