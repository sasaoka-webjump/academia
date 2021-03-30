<?php
require_once(__DIR__ . '/vendor/autoload.php');

use App\EnvironmentVariablesLoader;
use App\Models\Customers\CustomerPerson;
use Illuminate\Database\Capsule\Manager as Capsule;

EnvironmentVariablesLoader::start();

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => $_ENV['DB_DRIVER'],
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_NAME'],
    'username'  => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASSWORD'],
    'port'      => '3306',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',


]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

try {

    Capsule::schema()->disableForeignKeyConstraints();

    // Recreates Customers table
    Capsule::schema()->dropIfExists('customers');

    echo 'creating customers table...' . PHP_EOL;
    Capsule::schema()->create('customers', function ($table) {
        $table->increments('id');
        $table->string('accountNumber')->unique();
        $table->string('password');
        $table->string('phone_number');
        $table->string('zip_code');
        $table->string('adress_state');
        $table->string('adress_city');
        $table->string('adress_district');
        $table->string('adress_street');
        $table->string('adress_number');
        $table->string('adress_complement');
        $table->boolean('is_company')->default(false);
        $table->timestamps();
    });

    // Recreates the CustomerPeopleData table
    Capsule::schema()->dropIfExists('customer_people_registration_data');

    echo 'creating customer_people_registration_data table...' . PHP_EOL;
    Capsule::schema()->create('customer_people_registration_data', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('cpf');
        $table->string('national_identity_card');
        $table->date('birth_date');
        $table->timestamps();
    });

    echo 'Adding foreign key constraint...' . PHP_EOL;
    Capsule::schema()->table('customer_people_registration_data', function ($table) {
        $table->unsignedInteger('customer_id');
        $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
    });

    // Recreates the CustomerCompaniesData table
    Capsule::schema()->dropIfExists('customer_companies_registration_data');

    echo 'creating customer_companies_registration_data table...' . PHP_EOL;
    Capsule::schema()->create('customer_companies_registration_data', function ($table) {
        $table->increments('id');
        $table->string('company_name');
        $table->string('cnpj');
        $table->string('state_registration');
        $table->date('foundation_date');
        $table->timestamps();
    });

    echo 'Adding foreign key constraint...' . PHP_EOL;
    Capsule::schema()->table('customer_companies_registration_data', function ($table) {
        $table->unsignedInteger('customer_id');
        $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
    });


    // Recreates the Transactions table
    Capsule::schema()->dropIfExists('transactions');

    echo 'creating transactions table...' . PHP_EOL;
    Capsule::schema()->create('transactions', function ($table) {
        $table->increments('id');
        $table->enum('type', ['withdraw', 'deposit', 'transfer']);
        $table->double('value');
        $table->timestamps();
    });

    echo 'Adding foreign key constraint...' . PHP_EOL;
    Capsule::schema()->table('transactions', function ($table) {
        $table->unsignedInteger('origin_customer_id');
        $table->unsignedInteger('destination_customer_id');
        $table->foreign('origin_customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('destination_customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
    });

    Capsule::schema()->enableForeignKeyConstraints();
    echo 'database migrated successfully!' . PHP_EOL;

    echo 'seeding the database...' . PHP_EOL;
    $customer = CustomerPerson::create([
        'accountNumber' => 'teste',
        'password' => md5('teste'),
        'phone_number' => '(31)3333-3333',
        'zip_code' => '35355355',
        'adress_state' => 'MG',
        'adress_city' => 'JF',
        'adress_district' => 'District',
        'adress_street' => 'street',
        'adress_number' => 'number',
        'adress_complement' => 'complement',
        'is_company' => false
    ]);
} catch (Exception $error) {
    echo 'Failed migrating the database!' . PHP_EOL;

    throw $error;
}
