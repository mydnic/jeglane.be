<?php

namespace Database\Seeders;

use App\Models\Gleanable;
use Illuminate\Database\Seeder;

class GleanablesSeeder extends Seeder
{
    public function run(): void
    {
        Gleanable::create(['name' => 'Carottes']);
        Gleanable::create(['name' => 'Pommes']);
        Gleanable::create(['name' => 'Poires']);
        Gleanable::create(['name' => 'Tomates']);
        Gleanable::create(['name' => 'Courgettes']);
        Gleanable::create(['name' => 'Concombres']);
        Gleanable::create(['name' => 'Salades']);
        Gleanable::create(['name' => 'Choux']);
        Gleanable::create(['name' => 'Radis']);
        Gleanable::create(['name' => 'Aubergines']);
        Gleanable::create(['name' => 'Poivrons']);
        Gleanable::create(['name' => 'Pommes de terre']);
        Gleanable::create(['name' => 'Oignons']);
        Gleanable::create(['name' => 'Ail']);
        Gleanable::create(['name' => 'Fraises']);
        Gleanable::create(['name' => 'Framboises']);
        Gleanable::create(['name' => 'Mûres']);
        Gleanable::create(['name' => 'Myrtilles']);
        Gleanable::create(['name' => 'Cerises']);
        Gleanable::create(['name' => 'Pêches']);
        Gleanable::create(['name' => 'Abricots']);
        Gleanable::create(['name' => 'Prunes']);
        Gleanable::create(['name' => 'Raisins']);
        Gleanable::create(['name' => 'Melons']);
        Gleanable::create(['name' => 'Citrouilles']);
        Gleanable::create(['name' => 'Courges']);
        Gleanable::create(['name' => 'Haricots']);
        Gleanable::create(['name' => 'Poivrons']);
    }
}
