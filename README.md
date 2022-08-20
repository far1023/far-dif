# DIF Indonesia Test Case #

This is a test case for DIF Indonesia PHP Developer and has been deployed to [dif-id.fuadagil.com/](https://dif-id.fuadagil.com/)

## Tech specifications ##

* Framework : [Laravel 9](https://laravel.com/docs/9.x)
* Database : MySQL

## Installation ##

1. Clone this repo
2. Get and import database file `far_dif_studicase.sql`
3. Read [this](https://stackoverflow.com/a/38437177/13086131)

## API endpoint ##

### baseURL = `localhost:8000/api/` for locally or `dif-id.fuadagil.com/api/`(tested environment) for remote server ###

### Endpoint list ###

If you choose VS Code as your playground, I extremely recommending [REST Client Extensions](https://marketplace.visualstudio.com/itemdetails?itemName=humao.rest-client) to perform request for this project.

URL | Method | Body | Params | Explanation
---|---|---|---|---|---
`/allowance` | GET | - | - | Get all allowance data
`/allowance` | GET | - | `/:id` | Get allowance data by given id
`/allowance` | POST | `{"name": <string.required>, "percentage_on_basic": <integer>, "fix_amount": <integer>}` | - | Add allowance data
`/allowance` | PATCH | `{"name": <string.required>, "percentage_on_basic": <integer>, "fix_amount": <integer>}` | `/:id` | Update allowance data by given id
`/allowance` | DELETE | - | `/:id` | Destroy allowance data by given id

`/employee` | GET | - | - | Get all employee data
`/employee` | GET | - | `/:id` | Get employee data by given id
`/employee` | POST | `{"name": <string.required>, "pob": <string.required>, "dob": <date('Y-m-d').required>, "gender": <enum('male', 'female').required>, "contact": <string.required>, "emai": <string.required>, "address": <text>}` | - | Add employee data
`/employee` | PATCH | `{"name": <string.required>, "pob": <string.required>, "dob": <date('Y-m-d').required>, "gender": <enum('male', 'female').required>, "contact": <string.required>, "emai": <string.required>, "address": <text>}` | `/:id` | Update employee data by given id
`/employee` | DELETE | - | `/:id` | Destroy employee data by given id

`/contract` | GET | - | - | Get all employee contract data
`/contract` | GET | - | `/:id` | Get employee contract data by given id
`/contract` | POST | `{"contract_no": <string.required.unique>, "employee_id": <integer.required.exist_in_db>, "position": <string.required>, "division": <string.required>, "start": <date('Y-m-d').required>, "end": <date('Y-m-d').required>, "basic_salary": <integer.required>}` | - | Add employee contract data
`/contract` | PATCH | `{"contract_no": <string.required.unique>, "employee_id": <integer.required.exist_in_db>, "position": <string.required>, "division": <string.required>, "start": <date('Y-m-d').required>, "end": <date('Y-m-d').required>, "basic_salary": <integer.required>}` | `/:id` | Update employee contract data by given id
`/contract` | DELETE | - | `/:id` | Destroy employee contract data by given id

`/employee-has-allowance` | POST | `{"employee_id": <integer.exist_in_db>, "allowances": <array>` | - | Add employee's allowances. If he/she already has allowances, system will destroy all his/her allowance data before adding the new one. 

`/payroll` | GET | - | - | Get all payroll data
`/payroll` | GET | - | `/:id` | Get payroll data by given id
`/payroll` | POST | `{"month": <string.required>, "year": <integer.required>, "employee_id": <integer>}` | - | Generate payroll data
`/payroll` | DELETE | - | `/:id` | Destroy payroll data by given id