<?php
function getChildKey($data)
{
    $result = [];

    if (isset($data['child'])) {
        foreach ($data['child'] as $key => $value) {
            $result[$key] = getChildKey($value);
        }
    }

    if (empty($result)) {
        return '';
    }

    return $result;
}

$input = [
        'item'  => null,
        'count' => 0,
        'child' => [
            'Dagadu' => 
            [
                'item' => 'Dagadu',
                'count' => 341,
                'child' =>null,
            ],
            'DGD' => 
                [
                    'item' => 'DGD',
                    'count' => 341,
                    'child' => [
                            'DGD' => 
                         [
                        'item' => 'DGD',
                        'count' => 341,
                        'child' =>null,    
                         ]
                     ]    
                 ]
            ]
];

$output = [];
$output[]=getChildKey($input);
// foreach ($input as $index => $child) {
//     $output[$index] = getChildKey($child);
// }

echo '<pre>';
print_r($output);
echo '</pre>';