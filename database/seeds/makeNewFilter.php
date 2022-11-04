<?php

use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterOption;
use App\Models\Translation\FilterOptionTranslation;
use App\Models\Translation\FilterTranslation;
use Illuminate\Database\Seeder;

class makeNewFilter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::whereNotNull('parent_id')->get();

        foreach ($categories as $category) {

            $filter = Filter::create([
                'category_id' => $category->id,
            ]);

            FilterTranslation::updateOrCreate([
                'filter_id' => $filter->id,
                'locale' => 'pt',
            ], [
                'title' => 'Idioma do curso', // Nome da Categoria a ser adicionada
            ]);



            $filterOptions = [
                ['title' => 'Português'],
                ['title' => 'Inglês'],
                ['title' => 'Espanhol'],
                ['title' => 'Outro idioma'],
            ];

            $allFilterOptionsIds = $filter->options->pluck('id')->toArray();
            if (!empty($filterOptions) and count($filterOptions)) {
                $order = 1;

                foreach ($filterOptions as $key => $filterOption) {
                    if (!empty($filterOption['title'])) {
                        $oldFilterOption = FilterOption::where('filter_id', $filter->id)->where('id', $key)->first();

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
                                'locale' => 'pt',
                            ], [
                                'title' => $filterOption['title'],
                            ]);
                        } else {
                            $option = FilterOption::create([
                                'filter_id' => $filter->id,
                                'order' => $order,
                            ]);

                            FilterOptionTranslation::updateOrCreate([
                                'filter_option_id' => $option->id,
                                'locale' => 'pt',
                            ], [
                                'title' => $filterOption['title'],
                            ]);
                        }

                        $order += 1;
                    }
                }
            }
        }
    }
}
