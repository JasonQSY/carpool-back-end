# Carpool-back-end API v1.0

## GET /list/get

### params

No param.

### return

```
{
   'version": '1.0',
    'error': 0,
    'msg': [
        {
            'act_id': 2
            'creator': 'Dustism',
            'name': 'Nvzhuang',
            'people': ['JasonQSY', 'Songqun', 'Luke'],
            'from': 'D20',
            'to': 'D21',
            'expectedNum': 3,
            'state': 0
        },
        {
            ....
        }
    ]
}
```

## GET /list/get/:id

### params

No param.

### return

```
{
   'version": '1.0',
    'error': 0,
    'msg': {
        'act_id': 2
        'creator': 'Dustism',
        'name': 'Nvzhuang',
        'people': ['JasonQSY', 'Songqun', 'Luke'],
        'from': 'D20',
        'to': 'D21',
        'expectedNum': 3,
        'state': 0
    },
}
```

## GET /user/login


## POST /list/add

## POST /list/update

## GET /list/drop

## POST /user/profile