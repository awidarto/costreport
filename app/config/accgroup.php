<?php

return array(
    'jvsoab'=>array(
            'ASSETS AND ACCUMULATED CHARGES'=>array('key'=>'assets','data'=>array(
                'Cash & Bank'=>array('key'=>'cash','is_head'=>false,'sql'=>'in','val'=>'1001002,1001004,1011201,1011101,1011212,1011202,1011301'),

                'SKKMIGAS Working Advance'=>array('key'=>'wadv','is_head'=>false,'sql'=>'in','val'=>'1101100'),

                'Receivables'=>array('key'=>'receivables','is_head'=>false,'sql'=>'in','val'=>'1101260,1201100,1221110,1251190'),

                'PSC Bonus'=>array('key'=>'pscbonus','is_head'=>false,'sql'=>'in','val'=>'1101100'),

                'Prepayments'=>array('key'=>'prepay','is_head'=>false,'sql'=>'in','val'=>'1101100'),

                'Deposit'=>array('key'=>'deposit','is_head'=>false,'sql'=>'in','val'=>'1101100'),

                'Inventory'=>array('key'=>'inventory','is_head'=>false,'sql'=>'like','val'=>'175%'),

                'Work In Progress (WIP)'=>array('key'=>'wip','is_head'=>false,'sql'=>'like','val'=>'200%'),

                'Plant, Property & Equipments'=>array('key'=>'ppe','is_head'=>false,'sql'=>'like','val'=>array('300%','350%') ),

                'Cummulative Partner Expenditures'=>array('key'=>'cpe','is_head'=>false,'sql'=>'in','val'=>'5015211,5015212,5015213,5015214,5015215,5015221,5015222,5015223,5015224,5015225'),

            )),

            'LIABILITIES AND PARTNER ADVANCES'=>array('key'=>'liabilities','data'=>array(

                'Account Payable'=>array('key'=>'cash','is_head'=>false,'sql'=>'like','val'=>'400%'),
                'Taxes Payable'=>array('key'=>'cash','is_head'=>false,'sql'=>'like','val'=>array('410%','420%')),
                'Accruals'=>array('key'=>'cash','is_head'=>false,'sql'=>'like','val'=>'450%'),
                'Intercompany'=>array('key'=>'cash','is_head'=>false,'sql'=>'like','val'=>'460%'),
                'Partners Advances'=>array('key'=>'cash','is_head'=>false,'sql'=>'like','val'=>'500%'),
                'Cutback Clearing'=>array('key'=>'cash','is_head'=>false,'sql'=>'like','val'=>'599%')

            )),

        ),

    );