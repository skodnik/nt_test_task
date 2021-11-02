# Результат выполнения тестового задания

Вариант выполнения задания в максимально простой реализации.

Успешное сохранение заказа:

```bash
$ php run.php
                                                                                                      
Step 1: Generate barcode
Result: 60059463

Step 2: Make first API request #1
Result: {"error":"barcode already exists"}

Step 1: Generate barcode
Result: 62208921

Step 2: Make first API request #2
Result: {"error":"barcode already exists"}

Step 1: Generate barcode
Result: 23123474

Step 2: Make first API request #3
Result: {"error":"barcode already exists"}

Step 1: Generate barcode
Result: 10930400

Step 2: Make first API request #4
Result: {"error":"barcode already exists"}

Step 1: Generate barcode
Result: 36235281

Step 2: Make first API request #5
Result: {"message":"order successfully booked"}

Step 3: Make second API request
Result: {"message":"order successfully approved"}

Step 4: Store an order
Result: Order stored successfully with barcode: 36235281

```

Без сохранения заказа:

```bash
$ php run.php

Step 1: Generate barcode
Result: 67453224

Step 2: Make first API request #1
Result: {"message":"order successfully booked"}

Step 3: Make second API request
Result: {"error":"no tickets"}

Step 4: Store an order
Result: Order not stored with error: no tickets
```