# Tenancy Project

### migrate database (step by step)
```sh
php artisan migrate --step
```

### Seed data on database
```sh
php artisan db:seed
```


### If env is **not production** and want fake tenant, you can run `FakeTenantSeeder` seeder class
```sh
php artisan db:seed --class=FakeTenantSeeder
```
