<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * BlackSpot Seeder - Auto-generated from DBSCAN clustering
 * 
 * Algorithm: DBSCAN (Density-Based Spatial Clustering of Applications with Noise)
 * Parameters: eps = 250m, minPts = 3
 * Total clusters: 89
 * Generated: 2026-05-10T05:29:24.779Z
 */
class BlackSpotSeeder extends Seeder
{
    public function run()
    {
        // Clear existing black spots
        DB::table('black_spots')->truncate();

        $blackspots = [
            [
                'name' => 'Titik Rawan 27 (71 kecelakaan)',
                'lat' => -7.679853016869844,
                'lng' => 110.84110372549532,
                'radius' => 1332,
            ],
            [
                'name' => 'Titik Rawan 17 (64 kecelakaan)',
                'lat' => -7.551459484575045,
                'lng' => 110.7356835090779,
                'radius' => 1054,
            ],
            [
                'name' => 'Titik Rawan 11 (49 kecelakaan)',
                'lat' => -7.560029265464857,
                'lng' => 110.76581685452814,
                'radius' => 1213,
            ],
            [
                'name' => 'Titik Rawan 18 (31 kecelakaan)',
                'lat' => -7.659719342044132,
                'lng' => 110.83516194767515,
                'radius' => 801,
            ],
            [
                'name' => 'Titik Rawan 44 (29 kecelakaan)',
                'lat' => -7.606538990036552,
                'lng' => 110.86983586544075,
                'radius' => 906,
            ],
            [
                'name' => 'Titik Rawan 9 (28 kecelakaan)',
                'lat' => -7.607037224190458,
                'lng' => 110.8176926909028,
                'radius' => 801,
            ],
            [
                'name' => 'Titik Rawan 26 (21 kecelakaan)',
                'lat' => -7.5960644990575865,
                'lng' => 110.81473533016495,
                'radius' => 801,
            ],
            [
                'name' => 'Titik Rawan 36 (20 kecelakaan)',
                'lat' => -7.676139743832941,
                'lng' => 110.79533910436692,
                'radius' => 585,
            ],
            [
                'name' => 'Titik Rawan 10 (16 kecelakaan)',
                'lat' => -7.559404425096803,
                'lng' => 110.74896580492394,
                'radius' => 630,
            ],
            [
                'name' => 'Titik Rawan 21 (16 kecelakaan)',
                'lat' => -7.555789112052729,
                'lng' => 110.74920840834878,
                'radius' => 426,
            ],
            [
                'name' => 'Titik Rawan 50 (16 kecelakaan)',
                'lat' => -7.613730244344793,
                'lng' => 110.89257946631496,
                'radius' => 598,
            ],
            [
                'name' => 'Titik Rawan 19 (15 kecelakaan)',
                'lat' => -7.622682991311007,
                'lng' => 110.82202392987546,
                'radius' => 259,
            ],
            [
                'name' => 'Titik Rawan 23 (15 kecelakaan)',
                'lat' => -7.631539936762773,
                'lng' => 110.82592498757427,
                'radius' => 447,
            ],
            [
                'name' => 'Titik Rawan 1 (14 kecelakaan)',
                'lat' => -7.54537804494,
                'lng' => 110.72357119528108,
                'radius' => 369,
            ],
            [
                'name' => 'Titik Rawan 59 (14 kecelakaan)',
                'lat' => -7.564276957461258,
                'lng' => 110.76562869555765,
                'radius' => 526,
            ],
            [
                'name' => 'Titik Rawan 7 (13 kecelakaan)',
                'lat' => -7.572580583227207,
                'lng' => 110.71852092897294,
                'radius' => 609,
            ],
            [
                'name' => 'Titik Rawan 43 (13 kecelakaan)',
                'lat' => -7.705357760066478,
                'lng' => 110.85566086227338,
                'radius' => 356,
            ],
            [
                'name' => 'Titik Rawan 83 (13 kecelakaan)',
                'lat' => -7.616711110914027,
                'lng' => 110.81984676591784,
                'radius' => 329,
            ],
            [
                'name' => 'Titik Rawan 24 (12 kecelakaan)',
                'lat' => -7.58480567285481,
                'lng' => 110.73894843346456,
                'radius' => 630,
            ],
            [
                'name' => 'Titik Rawan 25 (12 kecelakaan)',
                'lat' => -7.638871385044696,
                'lng' => 110.82866508784376,
                'radius' => 286,
            ],
            [
                'name' => 'Titik Rawan 34 (11 kecelakaan)',
                'lat' => -7.594085903130729,
                'lng' => 110.74190099506299,
                'radius' => 295,
            ],
            [
                'name' => 'Titik Rawan 2 (10 kecelakaan)',
                'lat' => -7.578707854602728,
                'lng' => 110.76035985569641,
                'radius' => 342,
            ],
            [
                'name' => 'Titik Rawan 20 (10 kecelakaan)',
                'lat' => -7.58299261174105,
                'lng' => 110.7134892553953,
                'radius' => 503,
            ],
            [
                'name' => 'Titik Rawan 31 (10 kecelakaan)',
                'lat' => -7.587121398894025,
                'lng' => 110.80495847737708,
                'radius' => 513,
            ],
            [
                'name' => 'Titik Rawan 5 (9 kecelakaan)',
                'lat' => -7.6269951158499,
                'lng' => 110.83515169157434,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 57 (9 kecelakaan)',
                'lat' => -7.618477046913491,
                'lng' => 110.776525954006,
                'radius' => 445,
            ],
            [
                'name' => 'Titik Rawan 16 (8 kecelakaan)',
                'lat' => -7.694222148517317,
                'lng' => 110.84884578189501,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 22 (8 kecelakaan)',
                'lat' => -7.584306105943775,
                'lng' => 110.784419984646,
                'radius' => 297,
            ],
            [
                'name' => 'Titik Rawan 32 (8 kecelakaan)',
                'lat' => -7.598315844315067,
                'lng' => 110.7845748565505,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 38 (8 kecelakaan)',
                'lat' => -7.697533127285045,
                'lng' => 110.85061699445599,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 42 (8 kecelakaan)',
                'lat' => -7.578458065432769,
                'lng' => 110.78294921436662,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 70 (8 kecelakaan)',
                'lat' => -7.638285606719093,
                'lng' => 110.89153019415087,
                'radius' => 332,
            ],
            [
                'name' => 'Titik Rawan 3 (7 kecelakaan)',
                'lat' => -7.579762227426668,
                'lng' => 110.76611375237728,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 41 (7 kecelakaan)',
                'lat' => -7.62175009749591,
                'lng' => 110.76749834008702,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 45 (7 kecelakaan)',
                'lat' => -7.702342342287031,
                'lng' => 110.82343574332744,
                'radius' => 397,
            ],
            [
                'name' => 'Titik Rawan 51 (7 kecelakaan)',
                'lat' => -7.566307456208909,
                'lng' => 110.77885612054,
                'radius' => 406,
            ],
            [
                'name' => 'Titik Rawan 54 (7 kecelakaan)',
                'lat' => -7.606313473042557,
                'lng' => 110.79204645437358,
                'radius' => 340,
            ],
            [
                'name' => 'Titik Rawan 56 (7 kecelakaan)',
                'lat' => -7.606880936583133,
                'lng' => 110.7855793330923,
                'radius' => 282,
            ],
            [
                'name' => 'Titik Rawan 65 (7 kecelakaan)',
                'lat' => -7.624815651689319,
                'lng' => 110.89367751585398,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 85 (7 kecelakaan)',
                'lat' => -7.635643873181148,
                'lng' => 110.86796085625626,
                'radius' => 364,
            ],
            [
                'name' => 'Titik Rawan 6 (6 kecelakaan)',
                'lat' => -7.71883057022296,
                'lng' => 110.80921822748617,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 15 (6 kecelakaan)',
                'lat' => -7.584531836776073,
                'lng' => 110.75108699582618,
                'radius' => 252,
            ],
            [
                'name' => 'Titik Rawan 33 (6 kecelakaan)',
                'lat' => -7.582990298370677,
                'lng' => 110.88093293618681,
                'radius' => 293,
            ],
            [
                'name' => 'Titik Rawan 49 (6 kecelakaan)',
                'lat' => -7.644604929844404,
                'lng' => 110.83026606675601,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 64 (6 kecelakaan)',
                'lat' => -7.589512780930311,
                'lng' => 110.70713541877801,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 67 (6 kecelakaan)',
                'lat' => -7.731849842746082,
                'lng' => 110.87030816397832,
                'radius' => 284,
            ],
            [
                'name' => 'Titik Rawan 74 (6 kecelakaan)',
                'lat' => -7.6004150745287165,
                'lng' => 110.87370004258982,
                'radius' => 325,
            ],
            [
                'name' => 'Titik Rawan 77 (6 kecelakaan)',
                'lat' => -7.607437528030985,
                'lng' => 110.8116655082235,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 12 (5 kecelakaan)',
                'lat' => -7.6586245246415645,
                'lng' => 110.797084619807,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 13 (5 kecelakaan)',
                'lat' => -7.735951865868896,
                'lng' => 110.7933332515958,
                'radius' => 323,
            ],
            [
                'name' => 'Titik Rawan 14 (5 kecelakaan)',
                'lat' => -7.722842156769566,
                'lng' => 110.8655722940492,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 28 (5 kecelakaan)',
                'lat' => -7.722270743288059,
                'lng' => 110.80591097293821,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 30 (5 kecelakaan)',
                'lat' => -7.732840377646772,
                'lng' => 110.7973017311526,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 35 (5 kecelakaan)',
                'lat' => -7.58835307384111,
                'lng' => 110.87931038242559,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 39 (5 kecelakaan)',
                'lat' => -7.68178815186989,
                'lng' => 110.81124861532501,
                'radius' => 256,
            ],
            [
                'name' => 'Titik Rawan 47 (5 kecelakaan)',
                'lat' => -7.654087465094049,
                'lng' => 110.8876719806922,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 48 (5 kecelakaan)',
                'lat' => -7.613380936504981,
                'lng' => 110.9096106169496,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 53 (5 kecelakaan)',
                'lat' => -7.693481395021213,
                'lng' => 110.8394723767278,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 55 (5 kecelakaan)',
                'lat' => -7.54286471135689,
                'lng' => 110.7167754724218,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 62 (5 kecelakaan)',
                'lat' => -7.6809101888886175,
                'lng' => 110.8328309377268,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 63 (5 kecelakaan)',
                'lat' => -7.633335305296898,
                'lng' => 110.8064975772526,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 71 (5 kecelakaan)',
                'lat' => -7.6698611371667935,
                'lng' => 110.79588030361901,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 73 (5 kecelakaan)',
                'lat' => -7.629857104736908,
                'lng' => 110.8977653019638,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 80 (5 kecelakaan)',
                'lat' => -7.664967047126629,
                'lng' => 110.796499808713,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 84 (5 kecelakaan)',
                'lat' => -7.682117079678113,
                'lng' => 110.8189555215506,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 4 (4 kecelakaan)',
                'lat' => -7.602111213836564,
                'lng' => 110.80455899601125,
                'radius' => 281,
            ],
            [
                'name' => 'Titik Rawan 8 (4 kecelakaan)',
                'lat' => -7.684691088316592,
                'lng' => 110.8498690469885,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 29 (4 kecelakaan)',
                'lat' => -7.6121970709431395,
                'lng' => 110.80939266418125,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 40 (4 kecelakaan)',
                'lat' => -7.603982841176938,
                'lng' => 110.78345693246123,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 52 (4 kecelakaan)',
                'lat' => -7.687243167122972,
                'lng' => 110.7969723289185,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 58 (4 kecelakaan)',
                'lat' => -7.71266891776884,
                'lng' => 110.8337515266625,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 61 (4 kecelakaan)',
                'lat' => -7.593036872370788,
                'lng' => 110.78600997785949,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 66 (4 kecelakaan)',
                'lat' => -7.6636711468075545,
                'lng' => 110.85945622761474,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 68 (4 kecelakaan)',
                'lat' => -7.685437401345552,
                'lng' => 110.87682596512676,
                'radius' => 251,
            ],
            [
                'name' => 'Titik Rawan 69 (4 kecelakaan)',
                'lat' => -7.59642397812085,
                'lng' => 110.85303730015676,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 72 (4 kecelakaan)',
                'lat' => -7.564975409248578,
                'lng' => 110.722835512082,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 75 (4 kecelakaan)',
                'lat' => -7.622032935919087,
                'lng' => 110.7784579139485,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 76 (4 kecelakaan)',
                'lat' => -7.79803425352903,
                'lng' => 110.77446094093824,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 79 (4 kecelakaan)',
                'lat' => -7.60813456132447,
                'lng' => 110.7976080015635,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 81 (4 kecelakaan)',
                'lat' => -7.580851502985752,
                'lng' => 110.7710151861975,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 82 (4 kecelakaan)',
                'lat' => -7.713918832615595,
                'lng' => 110.80089587807075,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 86 (4 kecelakaan)',
                'lat' => -7.591137506084671,
                'lng' => 110.84273514348301,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 87 (4 kecelakaan)',
                'lat' => -7.542459456756628,
                'lng' => 110.73702511162949,
                'radius' => 256,
            ],
            [
                'name' => 'Titik Rawan 88 (4 kecelakaan)',
                'lat' => -7.574507719580887,
                'lng' => 110.79675951763325,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 89 (4 kecelakaan)',
                'lat' => -7.615977900571686,
                'lng' => 110.8712574202285,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 91 (4 kecelakaan)',
                'lat' => -7.6819096356345,
                'lng' => 110.82547760130375,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 60 (3 kecelakaan)',
                'lat' => -7.588648529585541,
                'lng' => 110.81171566279266,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 78 (3 kecelakaan)',
                'lat' => -7.596476908447371,
                'lng' => 110.877016420147,
                'radius' => 250,
            ],
            [
                'name' => 'Titik Rawan 90 (3 kecelakaan)',
                'lat' => -7.599141453763839,
                'lng' => 110.80489570543334,
                'radius' => 250,
            ],
        ];

        foreach ($blackspots as $spot) {
            $geojson = json_encode([
                'type' => 'Point',
                'coordinates' => [$spot['lng'], $spot['lat']]
            ]);

            DB::statement(
                "INSERT INTO black_spots (name, location, radius, created_at, updated_at) VALUES (?, ST_GeomFromGeoJSON(?)::geography, ?, NOW(), NOW())",
                [$spot['name'], $geojson, $spot['radius']]
            );
        }

        echo "\n✅ Berhasil menyimpan " . count($blackspots) . " titik blackspot dari hasil DBSCAN clustering.\n";
    }
}
