<?php

use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterOption;
use App\Models\Translation\FilterOptionTranslation;
use App\Models\Translation\FilterTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateFilters extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $filters = Filter::join('filter_translations', 'filters.id', '=', 'filter_translations.filter_id')
            ->where('filter_translations.title', '=', 'Tipo de curso') // informar o título da categoria que será atualizada
            ->get();


        foreach ($filters as $filter) {

            $filter_id = $filter->filter_id;

            $filterOptions = FilterOption::where('filter_id', $filter_id)->pluck('id');

            $sub_filter = [];

            foreach ($filterOptions as $option) {
                $filter = FilterOptionTranslation::where('filter_option_id', $option)->select('title')->first();
                $sub_filter[$option] = ['title' => $filter->title];
            }

            $newValue1 = [
                "oxNxFsrfocVyPWjA" => ['title' => 'Técnico']
            ];

            $sub_filter = $this->insertArrayAtPosition($sub_filter, $newValue1, 1);

            $newValue2 = [
                "AMvvmNVfeWWtQsdj" => ['title' => 'Pós Técnico']
            ];

            $filterOptions = $this->insertArrayAtPosition($sub_filter, $newValue2, 2);

            $this->setSubFilters($filter_id, $filterOptions, 'pt');
        }
    }

    public function setSubFilters($filter_id, $filterOptions, $locale)
    {

        $allFilterOptionsIds = FilterOption::where('filter_id', $filter_id)->pluck('id')->toArray();


        if (!empty($filterOptions) and count($filterOptions)) {
            $order = 1;

            foreach ($filterOptions as $key => $filterOption) {
                if (!empty($filterOption['title'])) {
                    $oldFilterOption = FilterOption::where('filter_id', $filter_id)
                        ->where('id', $key)
                        ->first();

                    if (!empty($oldFilterOption)) {

                        $oldIdsSearch = array_search($key, $allFilterOptionsIds);

                        if ($oldIdsSearch !== -1) {
                            unset($allFilterOptionsIds[$oldIdsSearch]);
                        }

                        $oldFilterOption->update([
                            'order' => $order,
                        ]);

                        FilterOptionTranslation::updateOrCreate([
                            'filter_option_id' => $oldFilterOption->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $filterOption['title'],
                        ]);
                    } else {
                        $option = FilterOption::create([
                            'filter_id' => $filter_id,
                            'order' => $order,
                        ]);

                        FilterOptionTranslation::updateOrCreate([
                            'filter_option_id' => $option->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $filterOption['title'],
                        ]);
                    }

                    $order += 1;
                }
            }
        }

        if (!empty($allFilterOptionsIds) and count($allFilterOptionsIds)) {
            FilterOption::whereIn('id', $allFilterOptionsIds)->delete();
        }
    }


    function insertArrayAtPosition($array, $insert, $position)
    {
        /*
        $array : The initial array i want to modify
        $insert : the new array i want to add, eg array('key' => 'value') or array('value')
        $position : the position where the new array will be inserted into. Please mind that arrays start at 0
        */
        return array_slice($array, 0, $position, TRUE) + $insert + array_slice($array, $position, NULL, TRUE);
    }
}
