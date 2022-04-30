<?php
namespace App\Repositories;

use App\Dtos\CountryQueryParam;
use App\Interfaces\CountryInterface;
use App\Traits\ResponseAPI;
use App\Models\Country;
use Symfony\Component\Console\Output\ConsoleOutput;

class CountryRepository implements CountryInterface {

    use ResponseAPI; // use trait
    protected $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function getAllCountries(CountryQueryParam $queryParam) {

        $page = $queryParam->page;
        $perPage = $queryParam->page_size;
        $columns = ['*'];
        $pageName = 'page';

        $countries = Country::where('active', '=', true);

        if (strtolower($queryParam->order_by) == 'desc') {
            $countries = $countries->orderBy('id', 'DESC');
        } else {
            $countries = $countries->orderBy('id', 'ASC');
            $this->output->writeln(json_encode($countries->paginate()));
        }

        if($queryParam->search) {
            $countries = $countries->OrWhere('name', 'LIKE', "'%$queryParam->search%'")
                    ->orWhere('code', 'LIKE', "'%$queryParam->search%'");
        }

        $countries = $countries->paginate(
            $perPage = $perPage,
            $columns = $columns,
            $pageName = $pageName,
            $page = $page
        );
        // $this->output->writeln(json_encode($countries));

        return $countries;
    }

    public function createOrUpdateCountry(Country $country) {
        return $country->save();
    }

    public function checkCountryExists($country_name) {
        $result = Country::whereRaw("name LIKE '%" . $country_name ."%'")->first();
        return $result ? true : false;
    }

    public function getCountryById($id) {
        $country = Country::find($id);
        return $country;
    }

    public function deactivateCountry(Country $country) {
            $country->active = false;
            $country->save();

            return $country;
    }
}
