<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Src\Agenda\Company\Application\Mappers\AddressMapper;
use Src\Agenda\Company\Application\Mappers\CompanyMapper;
use Src\Agenda\Company\Application\Mappers\ContactMapper;
use Src\Agenda\Company\Application\Mappers\DepartmentMapper;
use Src\Agenda\Company\Domain\Factories\AddressFactory;
use Src\Agenda\Company\Domain\Factories\CompanyFactory;
use Src\Agenda\Company\Domain\Factories\ContactFactory;
use Src\Agenda\Company\Domain\Factories\DepartmentFactory;
use Src\Agenda\Company\Domain\Model\Company;
use Src\Agenda\Company\Domain\Model\Entities\Address;
use Src\Agenda\Company\Domain\Model\Entities\Contact;
use Src\Agenda\Company\Domain\Model\Entities\Department;

trait WithCompanies
{
    use WithFaker;

    protected function newCompany(): Company
    {
        $company = CompanyFactory::new();
        $companyEloquent = CompanyMapper::toEloquent($company);
        $companyEloquent->save();
        foreach ($company->addresses as $address) {
            $addressEloquent = AddressMapper::toEloquent($address);
            $addressEloquent->company_id = $companyEloquent->id;
            $addressEloquent->save();
        }
        return CompanyMapper::fromEloquent($companyEloquent, true);
    }

    protected function createRandomCompanies(int $companiesCount): void
    {
        foreach (range(1, $companiesCount) as $_) {
            $this->newCompany();
        }
    }

    protected function createAddress(int $company_id): Address
    {
        $address = AddressFactory::new();
        $addressEloquent = AddressMapper::toEloquent($address);
        $addressEloquent->company_id = $company_id;
        $addressEloquent->save();
        return AddressMapper::fromEloquent($addressEloquent);
    }

    protected function createDepartment(int $company_id): Department
    {
        $department = DepartmentFactory::new();
        $departmentEloquent = DepartmentMapper::toEloquent($department);
        $departmentEloquent->company_id = $company_id;
        $departmentEloquent->save();
        return DepartmentMapper::fromEloquent($departmentEloquent);
    }

    protected function createContact(int $company_id): Contact
    {
        $contact = ContactFactory::new();
        $contactEloquent = ContactMapper::toEloquent($contact);
        $contactEloquent->company_id = $company_id;
        $contactEloquent->save();
        return ContactMapper::fromEloquent($contactEloquent);
    }

}