<?php
    namespace App\Http\Controllers\search\symptom;

    use DB;
    use App\manager\connectionManager;

    class symptom
    {

        public function get($words)
        {

            $symptoms = DB::connection(
                app(connectionManager::class)->getConnection('anatomy')
            )->table('symptoms');
            $first_word = $words[0];

            $i=0;
            foreach($words as $word)
            {
                //****************** CASE 0 *************************
                //find in sypmtoms that one is body part and other is term
                $condition = $i == 0 ? 'where' : 'Orwhere';
                $symptoms->$condition('name', 'LIKE', "%$word%");
                $i++;
            }

            return $symptoms
            ->limit(8)
            ->orderByRaw("name REGEXP '^$first_word' DESC")
            ->get(['name as term']);

        }
    }

?>
