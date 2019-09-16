# Review REST APIs

## POST /V1/reviews/
Create review with ratings.

### REQUEST BODY
Create review with ratings
```json
{
  "review": {
    "title": "Review title",
    "detail": "Empty review datails!",
    "nickname": "Nickname",
    "ratings": [
      {
        "rating_name": "Rating",
        "value": 1
      },
      {
        "rating_name": "Quality",
        "value": 1
      }
    ],
    "review_entity": "product",
    "review_status": 2,
    "entity_pk_value": 14
  }
}
```

Create review without ratings
```json
{
  "review": {
    "title": "Review!!1",
    "detail": "Empty review datails!",
    "nickname": "Nickname",
    "review_entity": "product",
    "review_status": 2,
    "entity_pk_value": 14
  }
}

```


### RESPONSE BODY
```json
{
  "id": 105,
  "title": "Review title",
  "detail": "Empty review datails!",
  "nickname": "Nickname",
  "ratings": [
    {
      "vote_id": 115,
      "rating_name": "Rating",
      "value": 1
    },
    {
      "vote_id": 116,
      "rating_name": "Quality",
      "value": 1
    }
  ],
  "review_entity": "product",
  "review_type": 2,
  "review_status": 2,
  "created_at": "2019-09-16 08:31:44",
  "entity_pk_value": 14,
  "store_id": 1,
  "stores": [
    0,
    1
  ]
}
```
