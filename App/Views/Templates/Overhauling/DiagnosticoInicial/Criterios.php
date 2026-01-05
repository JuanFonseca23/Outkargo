<?php
header('Content-Type: application/json');

$Criterios = [
    "Bateria" => [
        // PASILLO
        "pasillo" => [
            ["label"=> "Estado de cables",               "name"=> "pasillo_1", "id"=>"pasillo_1", "hidden"=> "Criterio_1"],
            ["label"=> "Nivel de electrolito",           "name"=> "pasillo_2", "id"=>"pasillo_2", "hidden"=> "Criterio_2"],
            ["label"=> "Conector Anderson",              "name"=> "pasillo_3", "id"=>"pasillo_3", "hidden"=> "Criterio_3"],
            ["label"=> "Compartimiento de la batería",   "name"=> "pasillo_4", "id"=>"pasillo_4", "hidden"=> "Criterio_4"],
            ["label"=> "Estado de batería",              "name"=> "pasillo_5", "id"=>"pasillo_5", "hidden"=> "Criterio_5"],
            ["label"=> "Estado de los puentes",          "name"=> "pasillo_6", "id"=>"pasillo_6", "hidden"=> "Criterio_6"]
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Estado de cables",               "name"=> "contra_1", "id"=>"contra_1", "hidden"=> "Criterio_1"],
            ["label"=> "Nivel de electrolito",           "name"=> "contra_2", "id"=>"contra_2", "hidden"=> "Criterio_2"],
            ["label"=> "Conector Anderson",              "name"=> "contra_3", "id"=>"contra_3", "hidden"=> "Criterio_3"],
            ["label"=> "Compartimiento de la batería",   "name"=> "contra_4", "id"=>"contra_4", "hidden"=> "Criterio_4"],
            ["label"=> "Estado de batería",              "name"=> "contra_5", "id"=>"contra_5", "hidden"=> "Criterio_5"],
            ["label"=> "Estado de los puentes",          "name"=> "contra_6", "id"=>"contra_6", "hidden"=> "Criterio_6"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Estado de bornes",                "name"=> "comb_1", "id"=>"comb_1", "hidden"=> "Criterio_1"],
            ["label"=> "Cables de potencia",              "name"=> "comb_2", "id"=>"comb_2", "hidden"=> "Criterio_2"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Estado de cables",               "name"=> "manlift_1", "id"=>"manlift_1", "hidden"=> "Criterio_1"],
            ["label"=> "Nivel de electrolito",           "name"=> "manlift_2", "id"=>"manlift_2", "hidden"=> "Criterio_2"],
            ["label"=> "Conector Anderson",              "name"=> "manlift_3", "id"=>"manlift_3", "hidden"=> "Criterio_3"],
            ["label"=> "Compartimiento de la batería",   "name"=> "manlift_4", "id"=>"manlift_4", "hidden"=> "Criterio_4"],
            ["label"=> "Estado de batería",              "name"=> "manlift_5", "id"=>"manlift_5", "hidden"=> "Criterio_5"],
            ["label"=> "Estado de los puentes",          "name"=> "manlift_6", "id"=>"manlift_6", "hidden"=> "Criterio_6"]
        ]
    ],
    "Electrico" => [
        // PASILLO
        "pasillo" => [
            ["label"=> "Controlador tracción",                    "name"=> "pasillo_7", "id"=>"pasillo_7", "hidden"=> "Criterio_7"],
            ["label"=> "Controlador elevación",                   "name"=> "pasillo_8", "id"=>"pasillo_8", "hidden"=> "Criterio_8"],
            ["label"=> "Tarjeta tracción",                        "name"=> "pasillo_9", "id"=>"pasillo_9", "hidden"=> "Criterio_9"],
            ["label"=> "Tarjeta elevación",                       "name"=> "pasillo_10", "id"=>"pasillo_10", "hidden"=> "Criterio_10"],
            ["label"=> "ECU",                                     "name"=> "pasillo_11", "id"=>"pasillo_11", "hidden"=> "Criterio_11"],
            ["label"=> "MIB",                                     "name"=> "pasillo_12", "id"=>"pasillo_12", "hidden"=> "Criterio_12"],
            ["label"=> "Displey",                                 "name"=> "pasillo_13", "id"=>"pasillo_13", "hidden"=> "Criterio_13"],
            ["label"=> "Joystick",                                "name"=> "pasillo_14", "id"=>"pasillo_14", "hidden"=> "Criterio_14"],
            ["label"=> "Cables de potencia",                      "name"=> "pasillo_15", "id"=>"pasillo_15", "hidden"=> "Criterio_15"],
            ["label"=> "Desconector de emergencia",               "name"=> "pasillo_16", "id"=>"pasillo_16", "hidden"=> "Criterio_16"],
            ["label"=> "Cables de control",                       "name"=> "pasillo_17", "id"=>"pasillo_17", "hidden"=> "Criterio_17"],
            ["label"=> "Conectores",                              "name"=> "pasillo_18", "id"=>"pasillo_18", "hidden"=> "Criterio_18"],
            ["label"=> "Fusibles",                                "name"=> "pasillo_19", "id"=>"pasillo_19", "hidden"=> "Criterio_19"],
            ["label"=> "Contactor de línea",                      "name"=> "pasillo_20", "id"=>"pasillo_20", "hidden"=> "Criterio_20"],
            ["label"=> "Contactor de funciones auxiliares",       "name"=> "pasillo_21", "id"=>"pasillo_21", "hidden"=> "Criterio_21"],
            ["label"=> "Contactor elevación",                     "name"=> "pasillo_22", "id"=>"pasillo_22", "hidden"=> "Criterio_22"],
            ["label"=> "Micros",                                  "name"=> "pasillo_23", "id"=>"pasillo_23", "hidden"=> "Criterio_23"],
            ["label"=> "Switch de ignicion",                      "name"=> "pasillo_24", "id"=>"pasillo_24", "hidden"=> "Criterio_24"],
            ["label"=> "Cables de autosostenido",                 "name"=> "pasillo_25", "id"=>"pasillo_25", "hidden"=> "Criterio_25"],
            ["label"=> "Ventiladores",                            "name"=> "pasillo_26", "id"=>"pasillo_26", "hidden"=> "Criterio_26"],
            ["label"=> "Conversor de luces (VMC)",                "name"=> "pasillo_27", "id"=>"pasillo_27", "hidden"=> "Criterio_27"]
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Cables de potencia",                    "name"=> "contra_7", "id"=>"contra_7", "hidden"=> "Criterio_7"],
            ["label"=> "Desconector de emergencia",             "name"=> "contra_8", "id"=>"contra_8", "hidden"=> "Criterio_8"],
            ["label"=> "Cables de control",                     "name"=> "contra_9", "id"=>"contra_9", "hidden"=> "Criterio_9"],
            ["label"=> "Conectores",                            "name"=> "contra_10", "id"=>"contra_10", "hidden"=> "Criterio_10"],
            ["label"=> "Fusibles",                              "name"=> "contra_11", "id"=>"contra_11", "hidden"=> "Criterio_11"],
            ["label"=> "Controlador",                           "name"=> "contra_12", "id"=>"contra_12", "hidden"=> "Criterio_12"],
            ["label"=> "Displey",                               "name"=> "contra_13", "id"=>"contra_13", "hidden"=> "Criterio_13"],
            ["label"=> "Contactor linea",                       "name"=> "contra_14", "id"=>"contra_14", "hidden"=> "Criterio_14"],
            ["label"=> "Contactor direccion",                   "name"=> "contra_15", "id"=>"contra_15", "hidden"=> "Criterio_15"],
            ["label"=> "Contactor elevacion",                   "name"=> "contra_16", "id"=>"contra_16", "hidden"=> "Criterio_16"],
            ["label"=> "Contactor marcha",                      "name"=> "contra_17", "id"=>"contra_17", "hidden"=> "Criterio_17"],
            ["label"=> "Micros",                                "name"=> "contra_18", "id"=>"contra_18", "hidden"=> "Criterio_18"],
            ["label"=> "Switch de ignicion",                    "name"=> "contra_19", "id"=>"contra_19", "hidden"=> "Criterio_19"],
            ["label"=> "Potenciómetro de aceleración",          "name"=> "contra_20", "id"=>"contra_20", "hidden"=> "Criterio_20"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Caja de fusibles",                        "name"=> "comb_3", "id"=>"comb_3", "hidden"=> "Criterio_3"],
            ["label"=> "Conexiones",                              "name"=> "comb_4", "id"=>"comb_4", "hidden"=> "Criterio_4"],
            ["label"=> "Conectores",                              "name"=> "comb_5", "id"=>"comb_5", "hidden"=> "Criterio_5"],
            ["label"=> "Modulo de control eléctrico (ECU)",       "name"=> "comb_6", "id"=>"comb_6", "hidden"=> "Criterio_6"],
            ["label"=> "Display",                                 "name"=> "comb_7", "id"=>"comb_7", "hidden"=> "Criterio_7"],
            ["label"=> "Alternador",                              "name"=> "comb_8", "id"=>"comb_8", "hidden"=> "Criterio_8"],
            ["label"=> "Motor de arranque",                       "name"=> "comb_9", "id"=>"comb_9", "hidden"=> "Criterio_9"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Fusibles",                                    "name"=> "manlift_13", "id"=>"manlift_13", "hidden"=> "Criterio_13"],
            ["label"=> "Conexiones",                                  "name"=> "manlift_14", "id"=>"manlift_14", "hidden"=> "Criterio_14"],
            ["label"=> "Sistema de seguridad cables potencia",        "name"=> "manlift_15", "id"=>"manlift_15", "hidden"=> "Criterio_15"],
            ["label"=> "Conectores",                                  "name"=> "manlift_16", "id"=>"manlift_16", "hidden"=> "Criterio_16"],
            ["label"=> "Soportes",                                    "name"=> "manlift_17", "id"=>"manlift_17", "hidden"=> "Criterio_17"],
            ["label"=> "Cauchos",                                     "name"=> "manlift_18", "id"=>"manlift_18", "hidden"=> "Criterio_18"],
            ["label"=> "Controlador",                                 "name"=> "manlift_19", "id"=>"manlift_19", "hidden"=> "Criterio_19"],
            ["label"=> "Contactores",                                 "name"=> "manlift_20", "id"=>"manlift_20", "hidden"=> "Criterio_20"],
            ["label"=> "Displey",                                     "name"=> "manlift_21", "id"=>"manlift_21", "hidden"=> "Criterio_21"],
            ["label"=> "Contactor de linea",                          "name"=> "manlift_22", "id"=>"manlift_22", "hidden"=> "Criterio_22"],
            ["label"=> "Contactor de dirección",                      "name"=> "manlift_23", "id"=>"manlift_23", "hidden"=> "Criterio_23"],
            ["label"=> "Contactor de elevacion",                      "name"=> "manlift_24", "id"=>"manlift_24", "hidden"=> "Criterio_24"],
            ["label"=> "Contactores de marcha",                       "name"=> "manlift_25", "id"=>"manlift_25", "hidden"=> "Criterio_25"]
        ]
    ],
    "Traccion"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Motor de tracción",              "name"=> "pasillo_28", "id"=>"pasillo_28", "hidden"=> "Criterio_28"],
            ["label"=> "Escobillas",                     "name"=> "pasillo_29", "id"=>"pasillo_29", "hidden"=> "Criterio_29"],
            ["label"=> "Cremallera",                     "name"=> "pasillo_30", "id"=>"pasillo_30", "hidden"=> "Criterio_30"],
            ["label"=> "Rodamiento tornamesa",           "name"=> "pasillo_31", "id"=>"pasillo_31", "hidden"=> "Criterio_31"],
            ["label"=> "Transmisión",                    "name"=> "pasillo_32", "id"=>"pasillo_32", "hidden"=> "Criterio_32"],
            ["label"=> "Nivel de valvulina",             "name"=> "pasillo_33", "id"=>"pasillo_33", "hidden"=> "Criterio_33"],
            ["label"=> "Tornilleria",                    "name"=> "pasillo_34", "id"=>"pasillo_34", "hidden"=> "Criterio_34"]
        ],
        //CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Motor de tracción",            "name"=> "contra_21", "id"=>"contra_21", "hidden"=> "Criterio_21"],
            ["label"=> "Escobillas",                   "name"=> "contra_22", "id"=>"contra_22", "hidden"=> "Criterio_22"],
            ["label"=> "Micros de marchas",            "name"=> "contra_23", "id"=>"contra_23", "hidden"=> "Criterio_23"],
            ["label"=> "Transmisión",                  "name"=> "contra_24", "id"=>"contra_24", "hidden"=> "Criterio_24"],
            ["label"=> "Nivel de valvulina",           "name"=> "contra_25", "id"=>"contra_25", "hidden"=> "Criterio_25"],
            ["label"=> "Tornilleria",                  "name"=> "contra_26", "id"=>"contra_26", "hidden"=> "Criterio_26"]
        ]
    ],
    "Frenos"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Liquido de frenos",             "name"=> "pasillo_35", "id"=>"pasillo_35", "hidden"=> "Criterio_35"],
            ["label"=> "Bomba de freno principal",      "name"=> "pasillo_36", "id"=>"pasillo_36", "hidden"=> "Criterio_36"],
            ["label"=> "Bomba de freno auxiliar",       "name"=> "pasillo_37", "id"=>"pasillo_37", "hidden"=> "Criterio_37"],
            ["label"=> "Estado de bandas",              "name"=> "pasillo_38", "id"=>"pasillo_38", "hidden"=> "Criterio_38"],
            ["label"=> "Electrofreno",                  "name"=> "pasillo_39", "id"=>"pasillo_39", "hidden"=> "Criterio_39"],
            ["label"=> "Estado pastillas",              "name"=> "pasillo_40", "id"=>"pasillo_40", "hidden"=> "Criterio_40"],
            ["label"=> "Eficiencia de frenado",         "name"=> "pasillo_41", "id"=>"pasillo_41", "hidden"=> "Criterio_41"]
        ],
        //CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Liquido de frenos",               "name"=> "contra_27", "id"=>"contra_27", "hidden"=> "Criterio_27"],
            ["label"=> "Bomba de freno principal",        "name"=> "contra_28", "id"=>"contra_28", "hidden"=> "Criterio_28"],
            ["label"=> "Estado de bandas",                "name"=> "contra_29", "id"=>"contra_29", "hidden"=> "Criterio_29"],
            ["label"=> "Rodamientos",                     "name"=> "contra_30", "id"=>"contra_30", "hidden"=> "Criterio_30"],
            ["label"=> "Freno de estacionamiento",        "name"=> "contra_31", "id"=>"contra_31", "hidden"=> "Criterio_31"],
            ["label"=> "Eficiencia de frenado",           "name"=> "contra_32", "id"=>"contra_32", "hidden"=> "Criterio_32"],
            ["label"=> "Guayas de parqueo",               "name"=> "contra_33", "id"=>"contra_33", "hidden"=> "Criterio_33"],
            ["label"=> "Pedal de freno",                  "name"=> "contra_34", "id"=>"contra_34", "hidden"=> "Criterio_34"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Liquido de frenos",                      "name"=> "comb_77", "id"=>"comb_77", "hidden"=> "Criterio_77"],
            ["label"=> "Bomba de freno principal",               "name"=> "comb_78", "id"=>"comb_78", "hidden"=> "Criterio_78"],
            ["label"=> "Estado de bandas",                       "name"=> "comb_79", "id"=>"comb_79", "hidden"=> "Criterio_79"],
            ["label"=> "Rodamientos",                            "name"=> "comb_80", "id"=>"comb_80", "hidden"=> "Criterio_80"],
            ["label"=> "Freno de estacionamiento",               "name"=> "comb_81", "id"=>"comb_81", "hidden"=> "Criterio_81"],
            ["label"=> "Eficiencia de frenado",                  "name"=> "comb_82", "id"=>"comb_82", "hidden"=> "Criterio_82"],
            ["label"=> "Guayas de parqueo",                      "name"=> "comb_83", "id"=>"comb_83", "hidden"=> "Criterio_83"],
            ["label"=> "Pedal de freno",                         "name"=> "comb_84", "id"=>"comb_84", "hidden"=> "Criterio_84"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Eficiencia del mecanismo",                                "name"=> "manlift_76", "id"=>"manlift_76", "hidden"=> "Criterio_76"],
            ["label"=> "Estado desgaste del disco",                               "name"=> "manlift_77", "id"=>"manlift_77", "hidden"=> "Criterio_77"],
            ["label"=> "Nivel del aceite hidráulico de los frenos",               "name"=> "manlift_78", "id"=>"manlift_78", "hidden"=> "Criterio_78"],
            ["label"=> "Pedal de frenos",                                         "name"=> "manlift_79", "id"=>"manlift_79", "hidden"=> "Criterio_79"],
            ["label"=> "Bomba de frenado",                                        "name"=> "manlift_80", "id"=>"manlift_80", "hidden"=> "Criterio_80"],
            ["label"=> "Desgastes de pastillas de freno",                         "name"=> "manlift_81", "id"=>"manlift_81", "hidden"=> "Criterio_81"]
        ]
    ],
    "Direccion"=>[
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Motor de dirección",           "name"=> "contra_35", "id"=>"contra_35", "hidden"=> "Criterio_35"],
            ["label"=> "Escobillas",                   "name"=> "contra_36", "id"=>"contra_36", "hidden"=> "Criterio_36"],
            ["label"=> "Bomba de dirección",           "name"=> "contra_37", "id"=>"contra_37", "hidden"=> "Criterio_37"],
            ["label"=> "Mangueras",                    "name"=> "contra_38", "id"=>"contra_38", "hidden"=> "Criterio_38"],
            ["label"=> "Cilindro de dirección",        "name"=> "contra_39", "id"=>"contra_39", "hidden"=> "Criterio_39"],
            ["label"=> "Cauchos puente trasero",       "name"=> "contra_40", "id"=>"contra_40", "hidden"=> "Criterio_40"],
            ["label"=> "Rótulas",                      "name"=> "contra_41", "id"=>"contra_41", "hidden"=> "Criterio_41"],
            ["label"=> "Guarda polvo",                 "name"=> "contra_42", "id"=>"contra_42", "hidden"=> "Criterio_42"],
            ["label"=> "Rodamientos",                  "name"=> "contra_43", "id"=>"contra_43", "hidden"=> "Criterio_43"],
            ["label"=> "Orbitrol",                     "name"=> "contra_44", "id"=>"contra_44", "hidden"=> "Criterio_44"],
            ["label"=> "Terminales de dirección",      "name"=> "contra_45", "id"=>"contra_45", "hidden"=> "Criterio_45"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Mangueras",                       "name"=> "comb_85", "id"=>"comb_85", "hidden"=> "Criterio_85"],
            ["label"=> "Cilindro de dirección",           "name"=> "comb_86", "id"=>"comb_86", "hidden"=> "Criterio_86"],
            ["label"=> "Cauchos puente trasero",          "name"=> "comb_87", "id"=>"comb_87", "hidden"=> "Criterio_87"],
            ["label"=> "Rotulas",                         "name"=> "comb_88", "id"=>"comb_88", "hidden"=> "Criterio_88"],
            ["label"=> "Guarda polvo",                    "name"=> "comb_89", "id"=>"comb_89", "hidden"=> "Criterio_89"],
            ["label"=> "Rodamientos",                     "name"=> "comb_90", "id"=>"comb_90", "hidden"=> "Criterio_90"],
            ["label"=> "Orbitrol",                        "name"=> "comb_91", "id"=>"comb_91", "hidden"=> "Criterio_91"],
            ["label"=> "Terminales de dirección",         "name"=> "comb_92", "id"=>"comb_92", "hidden"=> "Criterio_92"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Generador de torque",                           "name"=> "manlift_53", "id"=>"manlift_53", "hidden"=> "Criterio_53"],
            ["label"=> "Escobillas",                                    "name"=> "manlift_54", "id"=>"manlift_54", "hidden"=> "Criterio_54"],
            ["label"=> "Fugas por cilindro de direccion",               "name"=> "manlift_55", "id"=>"manlift_55", "hidden"=> "Criterio_55"],
            ["label"=> "Niveles de aceite y grasa",                     "name"=> "manlift_56", "id"=>"manlift_56", "hidden"=> "Criterio_56"],
            ["label"=> "Mangueras de dirección",                        "name"=> "manlift_57", "id"=>"manlift_57", "hidden"=> "Criterio_57"],
            ["label"=> "Columna de dirección",                          "name"=> "manlift_58", "id"=>"manlift_58", "hidden"=> "Criterio_58"],
            ["label"=> "Motor dirección",                               "name"=> "manlift_59", "id"=>"manlift_59", "hidden"=> "Criterio_59"],
            ["label"=> "Conexiones hidráulicas",                        "name"=> "manlift_60", "id"=>"manlift_60", "hidden"=> "Criterio_60"],
            ["label"=> "Funcionamiento del sistema de dirección",       "name"=> "manlift_61", "id"=>"manlift_61", "hidden"=> "Criterio_61"]
        ]
    ],
    "Hidraulico"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Nivel aceite hidraulico",                 "name"=> "pasillo_54", "id"=>"pasillo_54", "hidden"=> "Criterio_54"],
            ["label"=> "Motor de sistema hidraulico",             "name"=> "pasillo_55", "id"=>"pasillo_55", "hidden"=> "Criterio_55"],
            ["label"=> "Escobillas",                              "name"=> "pasillo_56", "id"=>"pasillo_56", "hidden"=> "Criterio_56"],
            ["label"=> "Bomba sistema hidraulico",                "name"=> "pasillo_57", "id"=>"pasillo_57", "hidden"=> "Criterio_57"],
            ["label"=> "Filtro de retorno",                       "name"=> "pasillo_58", "id"=>"pasillo_58", "hidden"=> "Criterio_58"],
            ["label"=> "Cuerpo de válvulas",                      "name"=> "pasillo_59", "id"=>"pasillo_59", "hidden"=> "Criterio_59"],
            ["label"=> "Electro válvulas",                        "name"=> "pasillo_60", "id"=>"pasillo_60", "hidden"=> "Criterio_60"],
            ["label"=> "Mangueras",                               "name"=> "pasillo_61", "id"=>"pasillo_61", "hidden"=> "Criterio_61"],
            ["label"=> "Micros de funciones hidráulicas",         "name"=> "pasillo_62", "id"=>"pasillo_62", "hidden"=> "Criterio_62"]
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Estado y nivel hidráulico",                "name"=> "contra_46", "id"=>"contra_46", "hidden"=> "Criterio_46"],
            ["label"=> "Motor de sistema hidráulico",              "name"=> "contra_47", "id"=>"contra_47", "hidden"=> "Criterio_47"],
            ["label"=> "Escobillas",                               "name"=> "contra_48", "id"=>"contra_48", "hidden"=> "Criterio_48"],
            ["label"=> "Caucho absorbedor de golpe",               "name"=> "contra_49", "id"=>"contra_49", "hidden"=> "Criterio_49"],
            ["label"=> "Bomba sistema hidráulico",                 "name"=> "contra_50", "id"=>"contra_50", "hidden"=> "Criterio_50"],
            ["label"=> "Filtro de retorno",                        "name"=> "contra_51", "id"=>"contra_51", "hidden"=> "Criterio_51"],
            ["label"=> "Cuerpo de válvulas",                       "name"=> "contra_52", "id"=>"contra_52", "hidden"=> "Criterio_52"],
            ["label"=> "Mangueras",                                "name"=> "contra_53", "id"=>"contra_53", "hidden"=> "Criterio_53"],
            ["label"=> "Micros de funciones hidráulicas",          "name"=> "contra_54", "id"=>"contra_54", "hidden"=> "Criterio_54"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Estado y nivel aceite hidraulico",            "name"=> "comb_10", "id"=>"comb_10", "hidden"=> "Criterio_10"],
            ["label"=> "Bomba sistema hidraulico",                    "name"=> "comb_11", "id"=>"comb_11", "hidden"=> "Criterio_11"],
            ["label"=> "Filtro de retorno",                           "name"=> "comb_12", "id"=>"comb_12", "hidden"=> "Criterio_12"],
            ["label"=> "Bloque de valvulas",                          "name"=> "comb_13", "id"=>"comb_13", "hidden"=> "Criterio_13"],
            ["label"=> "Mangueras",                                   "name"=> "comb_14", "id"=>"comb_14", "hidden"=> "Criterio_14"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Estado y nivel de aceite",                           "name"=> "manlift_26", "id"=>"manlift_26", "hidden"=> "Criterio_26"],
            ["label"=> "Fugas",                                              "name"=> "manlift_27", "id"=>"manlift_27", "hidden"=> "Criterio_27"],
            ["label"=> "Filtros",                                            "name"=> "manlift_28", "id"=>"manlift_28", "hidden"=> "Criterio_28"],
            ["label"=> "Funcionamiento de válvulas",                         "name"=> "manlift_29", "id"=>"manlift_29", "hidden"=> "Criterio_29"],
            ["label"=> "Racores",                                            "name"=> "manlift_30", "id"=>"manlift_30", "hidden"=> "Criterio_30"],
            ["label"=> "Cilindros hidráulicos",                              "name"=> "manlift_31", "id"=>"manlift_31", "hidden"=> "Criterio_31"],
            ["label"=> "Bomba hidráulica",                                   "name"=> "manlift_32", "id"=>"manlift_32", "hidden"=> "Criterio_32"],
            ["label"=> "Estado de electroválvulas",                          "name"=> "manlift_33", "id"=>"manlift_33", "hidden"=> "Criterio_33"],
            ["label"=> "Abolladuras vástago y carcasa",                      "name"=> "manlift_34", "id"=>"manlift_34", "hidden"=> "Criterio_34"],
            ["label"=> "Ojos o juntas conexión sueltas o fisuradas",         "name"=> "manlift_35", "id"=>"manlift_35", "hidden"=> "Criterio_35"],
            ["label"=> "Estado de las mangueras",                            "name"=> "manlift_36", "id"=>"manlift_36", "hidden"=> "Criterio_36"],
            ["label"=> "Estado de las conexiónes",                           "name"=> "manlift_37", "id"=>"manlift_37", "hidden"=> "Criterio_37"],
            ["label"=> "Accionamiento normal sin bloqueos",                  "name"=> "manlift_38", "id"=>"manlift_38", "hidden"=> "Criterio_38"]
        ]
    ],
    "Mastil"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Ajuste mastil",                                   "name"=> "pasillo_63", "id"=>"pasillo_63", "hidden"=> "Criterio_63"],
            ["label"=> "Estado secciones",                                "name"=> "pasillo_64", "id"=>"pasillo_64", "hidden"=> "Criterio_64"],
            ["label"=> "Bujes",                                           "name"=> "pasillo_65", "id"=>"pasillo_65", "hidden"=> "Criterio_65"],
            ["label"=> "Rodamientos",                                     "name"=> "pasillo_66", "id"=>"pasillo_66", "hidden"=> "Criterio_66"],
            ["label"=> "Cadenas",                                         "name"=> "pasillo_67", "id"=>"pasillo_67", "hidden"=> "Criterio_67"],
            ["label"=> "Poleas",                                          "name"=> "pasillo_68", "id"=>"pasillo_68", "hidden"=> "Criterio_68"],
            ["label"=> "Pasadores cadenas",                               "name"=> "pasillo_69", "id"=>"pasillo_69", "hidden"=> "Criterio_69"],
            ["label"=> "Mangueras free lift",                             "name"=> "pasillo_70", "id"=>"pasillo_70", "hidden"=> "Criterio_70"],
            ["label"=> "Mangueras side shift",                            "name"=> "pasillo_71", "id"=>"pasillo_71", "hidden"=> "Criterio_71"],
            ["label"=> "Mangueras pantógrafo",                            "name"=> "pasillo_72", "id"=>"pasillo_72", "hidden"=> "Criterio_72"],
            ["label"=> "Tuberías",                                        "name"=> "pasillo_73", "id"=>"pasillo_73", "hidden"=> "Criterio_73"],
            ["label"=> "Racores",                                         "name"=> "pasillo_74", "id"=>"pasillo_74", "hidden"=> "Criterio_74"],
            ["label"=> "Cilindro de free lift",                           "name"=> "pasillo_75", "id"=>"pasillo_75", "hidden"=> "Criterio_75"],
            ["label"=> "Cilindros laterales",                             "name"=> "pasillo_76", "id"=>"pasillo_76", "hidden"=> "Criterio_76"],
            ["label"=> "Cilindro de side shif",                           "name"=> "pasillo_77", "id"=>"pasillo_77", "hidden"=> "Criterio_77"],
            ["label"=> "Cilindros de pantógrafo",                         "name"=> "pasillo_78", "id"=>"pasillo_78", "hidden"=> "Criterio_78"],
            ["label"=> "Bloque de válvulas funciones auxiliares",         "name"=> "pasillo_79", "id"=>"pasillo_79", "hidden"=> "Criterio_79"]
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Ajuste mastil",                     "name"=> "contra_55", "id"=>"contra_55", "hidden"=> "Criterio_55"],
            ["label"=> "Estado secciones",                  "name"=> "contra_56", "id"=>"contra_56", "hidden"=> "Criterio_56"],
            ["label"=> "Bujes",                             "name"=> "contra_57", "id"=>"contra_57", "hidden"=> "Criterio_57"],
            ["label"=> "Rodamientos",                       "name"=> "contra_58", "id"=>"contra_58", "hidden"=> "Criterio_58"],
            ["label"=> "Cadenas",                           "name"=> "contra_59", "id"=>"contra_59", "hidden"=> "Criterio_59"],
            ["label"=> "Poleas",                            "name"=> "contra_60", "id"=>"contra_60", "hidden"=> "Criterio_60"],
            ["label"=> "Pasadores cadenas",                 "name"=> "contra_61", "id"=>"contra_61", "hidden"=> "Criterio_61"],
            ["label"=> "Mangueras free lift",               "name"=> "contra_62", "id"=>"contra_62", "hidden"=> "Criterio_62"],
            ["label"=> "Mangueras side shift",              "name"=> "contra_63", "id"=>"contra_63", "hidden"=> "Criterio_63"],
            ["label"=> "Mangueras fork positioner",         "name"=> "contra_64", "id"=>"contra_64", "hidden"=> "Criterio_64"],
            ["label"=> "Tuberías",                          "name"=> "contra_65", "id"=>"contra_65", "hidden"=> "Criterio_65"],
            ["label"=> "Racores",                           "name"=> "contra_66", "id"=>"contra_66", "hidden"=> "Criterio_66"],
            ["label"=> "Cilindros de inclinación",          "name"=> "contra_67", "id"=>"contra_67", "hidden"=> "Criterio_67"],
            ["label"=> "Cilindro de free lift",             "name"=> "contra_68", "id"=>"contra_68", "hidden"=> "Criterio_68"],
            ["label"=> "Cilindros laterales",               "name"=> "contra_69", "id"=>"contra_69", "hidden"=> "Criterio_69"],
            ["label"=> "Cilindro de side shift",            "name"=> "contra_70", "id"=>"contra_70", "hidden"=> "Criterio_70"],
            ["label"=> "Cilindros de fork positioner",      "name"=> "contra_71", "id"=>"contra_71", "hidden"=> "Criterio_71"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Ajuste Mastil",                             "name"=> "comb_39", "id"=>"comb_39", "hidden"=> "Criterio_39"],
            ["label"=> "Estado secciones",                          "name"=> "comb_40", "id"=>"comb_40", "hidden"=> "Criterio_40"],
            ["label"=> "Bujes",                                     "name"=> "comb_41", "id"=>"comb_41", "hidden"=> "Criterio_41"],
            ["label"=> "Rodamientos",                               "name"=> "comb_42", "id"=>"comb_42", "hidden"=> "Criterio_42"],
            ["label"=> "Cadenas",                                   "name"=> "comb_43", "id"=>"comb_43", "hidden"=> "Criterio_43"],
            ["label"=> "Poleas",                                    "name"=> "comb_44", "id"=>"comb_44", "hidden"=> "Criterio_44"],
            ["label"=> "Pasadores Cadenas",                         "name"=> "comb_45", "id"=>"comb_45", "hidden"=> "Criterio_45"],
            ["label"=> "Mangueras free lift",                       "name"=> "comb_46", "id"=>"comb_46", "hidden"=> "Criterio_46"],
            ["label"=> "Mangueras side shift",                      "name"=> "comb_47", "id"=>"comb_47", "hidden"=> "Criterio_47"],
            ["label"=> "Mangueras fork positioner",                 "name"=> "comb_48", "id"=>"comb_48", "hidden"=> "Criterio_48"],
            ["label"=> "Tuberias",                                  "name"=> "comb_49", "id"=>"comb_49", "hidden"=> "Criterio_49"],
            ["label"=> "Racores",                                   "name"=> "comb_50", "id"=>"comb_50", "hidden"=> "Criterio_50"],
            ["label"=> "Cilindro de inclinación",                   "name"=> "comb_51", "id"=>"comb_51", "hidden"=> "Criterio_51"],
            ["label"=> "Cilindro de free lift",                     "name"=> "comb_52", "id"=>"comb_52", "hidden"=> "Criterio_52"],
            ["label"=> "Cilindros Laterales",                       "name"=> "comb_53", "id"=>"comb_53", "hidden"=> "Criterio_53"],
            ["label"=> "Cilindro de side shift",                    "name"=> "comb_54", "id"=>"comb_54", "hidden"=> "Criterio_54"],
            ["label"=> "Cilindros de fork positioner",              "name"=> "comb_55", "id"=>"comb_55", "hidden"=> "Criterio_55"]
        ]
    ],
    "CarroPorta"=>[
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Ajuste carro porta horquillas",                 "name"=> "contra_72", "id"=>"contra_72", "hidden"=> "Criterio_72"],
            ["label"=> "Rodamientos",                                   "name"=> "contra_73", "id"=>"contra_73", "hidden"=> "Criterio_73"],
            ["label"=> "Cadenas",                                       "name"=> "contra_74", "id"=>"contra_74", "hidden"=> "Criterio_74"],
            ["label"=> "Pasadores",                                     "name"=> "contra_75", "id"=>"contra_75", "hidden"=> "Criterio_75"],
            ["label"=> "Parilla o Espejo",                              "name"=> "contra_76", "id"=>"contra_76", "hidden"=> "Criterio_76"],
            ["label"=> "Mordazas",                                      "name"=> "contra_77", "id"=>"contra_77", "hidden"=> "Criterio_77"],
            ["label"=> "Deslizadores",                                  "name"=> "contra_78", "id"=>"contra_78", "hidden"=> "Criterio_78"]
        ],
    ],
    "Lubricacion"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Engrase de caster",                               "name"=> "pasillo_111", "id"=>"pasillo_111", "hidden"=> "Criterio_111"],
            ["label"=> "Engrase de tande",                                "name"=> "pasillo_112", "id"=>"pasillo_112", "hidden"=> "Criterio_112"],
            ["label"=> "Engrase de pantógrafo",                           "name"=> "pasillo_113", "id"=>"pasillo_113", "hidden"=> "Criterio_113"],
            ["label"=> "Lubricación cadenas y secciones mastil",          "name"=> "pasillo_114", "id"=>"pasillo_114", "hidden"=> "Criterio_114"]
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Engrase puente trasero",                              "name"=> "contra_79", "id"=>"contra_79", "hidden"=> "Criterio_79"],
            ["label"=> "Engrase mastil",                                      "name"=> "contra_80", "id"=>"contra_80", "hidden"=> "Criterio_80"],
            ["label"=> "Lubricacíon cadenas y secciones mastil",              "name"=> "contra_81", "id"=>"contra_81", "hidden"=> "Criterio_81"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Engrase puente trasero",                               "name"=> "comb_102", "id"=>"comb_102", "hidden"=> "Criterio_102"],
            ["label"=> "Engrase Mastil",                                       "name"=> "comb_103", "id"=>"comb_103", "hidden"=> "Criterio_103"],
            ["label"=> "Lubricacíon cadenas y secciones mastil",               "name"=> "comb_104", "id"=>"comb_104", "hidden"=> "Criterio_104"],
            ["label"=> "Engrase de cardan",                                    "name"=> "comb_105", "id"=>"comb_105", "hidden"=> "Criterio_105"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Engrasar - lubricar",                           "name"=> "manlift_62", "id"=>"manlift_62", "hidden"=> "Criterio_62"],
            ["label"=> "Engranajes - cadenas - piñones",                "name"=> "manlift_63", "id"=>"manlift_63", "hidden"=> "Criterio_63"]
        ]
    ],
    "Horquillas"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Seguros",                                                                             "name"=> "pasillo_90", "id"=>"pasillo_90", "hidden"=> "Criterio_90"],
            ["label"=> "Mordaza superior",                                                                    "name"=> "pasillo_91", "id"=>"pasillo_91", "hidden"=> "Criterio_91"],
            ["label"=> "Mordaza inferior",                                                                    "name"=> "pasillo_92", "id"=>"pasillo_92", "hidden"=> "Criterio_92"],
            ["label"=> "Clase de horquillas",                                                                 "name"=> "pasillo_ClaseH", "id"=>"pasillo_ClaseH", "hidden"=> "ClaseH"],
            ["label"=> "Longitud (m)",                                                                        "name"=> "pasillo_LongitudH", "id"=>"pasillo_LongitudH", "hidden"=> "LongitudH"],
            ["label"=> "Estado de horquillas (Inspeccion visual ver F208 como referencia)",                   "name"=> "pasillo_93", "id"=>"pasillo_93", "hidden"=> "Criterio_93"] 
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Seguros",                      "name"=> "contra_82", "id"=>"contra_82", "hidden"=> "Criterio_82"],
            ["label"=> "Mordaza superior",             "name"=> "contra_83", "id"=>"contra_83", "hidden"=> "Criterio_83"],
            ["label"=> "Mordaza inferior",             "name"=> "contra_84", "id"=>"contra_84", "hidden"=> "Criterio_84"],
            ["label"=> "Clase de horquillas",          "name"=> "contra_ClaseH", "id"=>"contra_ClaseH", "hidden"=> "ClaseH"],
            ["label"=> "Longitud (m)",                 "name"=> "contra_LongitudH", "id"=>"contra_LongitudH", "hidden"=> "LongitudH"],
            ["label"=> "Estado de horquillas",         "name"=> "contra_85", "id"=>"contra_85", "hidden"=> "Criterio_85"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Seguros",                        "name"=> "comb_59", "id"=>"comb_59", "hidden"=> "Criterio_59"],
            ["label"=> "Mordaza superior",               "name"=> "comb_60", "id"=>"comb_60", "hidden"=> "Criterio_60"],
            ["label"=> "Mordaza inferior",               "name"=> "comb_61", "id"=>"comb_61", "hidden"=> "Criterio_61"],
            ["label"=> "Clase de horquillas",            "name"=> "comb_ClaseH", "id"=>"comb_ClaseH", "hidden"=> "ClaseH"],
            ["label"=> "Longitud (m)",                   "name"=> "comb_LongitudH", "id"=>"comb_LongitudH", "hidden"=> "LongitudH"],
            ["label"=> "Estado de horquillas",           "name"=> "comb_62", "id"=>"comb_62", "hidden"=> "Criterio_62"]
        ]
    ],
    "Chasis"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Ajustes de conjunto",           "name"=> "pasillo_103", "id"=>"pasillo_103", "hidden"=> "Criterio_103"],
            ["label"=> "Chequear soportes",             "name"=> "pasillo_104", "id"=>"pasillo_104", "hidden"=> "Criterio_104"],
            ["label"=> "Tornilleria",                   "name"=> "pasillo_105", "id"=>"pasillo_105", "hidden"=> "Criterio_105"] 
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Ajustes de conjunto",      "name"=> "contra_86", "id"=>"contra_86", "hidden"=> "Criterio_86"],
            ["label"=> "Chequear soportes",        "name"=> "contra_87", "id"=>"contra_87", "hidden"=> "Criterio_87"],
            ["label"=> "Tornilleria",              "name"=> "contra_88", "id"=>"contra_88", "hidden"=> "Criterio_88"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Ajustes de conjunto",         "name"=> "comb_99", "id"=>"comb_99", "hidden"=> "Criterio_99"],
            ["label"=> "Chequear soportes",           "name"=> "comb_100", "id"=>"comb_100", "hidden"=> "Criterio_100"],
            ["label"=> "Tornilleria",                 "name"=> "comb_101", "id"=>"comb_101", "hidden"=> "Criterio_101"]
        ]
    ],
    "Ruedas"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Desgaste ruedas de tracción",              "name"=> "pasillo_94", "id"=>"pasillo_94", "hidden"=> "Criterio_94"],
            ["label"=> "Desgaste ruedas de caster",                "name"=> "pasillo_95", "id"=>"pasillo_95", "hidden"=> "Criterio_95"],
            ["label"=> "Desgaste ruedas de carga",                 "name"=> "pasillo_96", "id"=>"pasillo_96", "hidden"=> "Criterio_96"],
            ["label"=> "Estado de rines de tracción",              "name"=> "pasillo_97", "id"=>"pasillo_97", "hidden"=> "Criterio_97"],
            ["label"=> "Estado de rines de caster",                "name"=> "pasillo_98", "id"=>"pasillo_98", "hidden"=> "Criterio_98"],
            ["label"=> "Estado de rines de carga",                 "name"=> "pasillo_99", "id"=>"pasillo_99", "hidden"=> "Criterio_99"],
            ["label"=> "Balancines",                               "name"=> "pasillo_100", "id"=>"pasillo_100", "hidden"=> "Criterio_100"],
            ["label"=> "Tornillos",                                "name"=> "pasillo_101", "id"=>"pasillo_101", "hidden"=> "Criterio_101"],
            ["label"=> "Bujes",                                    "name"=> "pasillo_102", "id"=>"pasillo_102", "hidden"=> "Criterio_102"] 
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Desgaste de caucho de ruedas de carga",             "name"=> "contra_89", "id"=>"contra_89", "hidden"=> "Criterio_89"],
            ["label"=> "Desgaste de caucho de ruedas de dirección",         "name"=> "contra_90", "id"=>"contra_90", "hidden"=> "Criterio_90"],
            ["label"=> "Estado de rin de carga",                            "name"=> "contra_91", "id"=>"contra_91", "hidden"=> "Criterio_91"],
            ["label"=> "Estado de rin de dirección",                        "name"=> "contra_92", "id"=>"contra_92", "hidden"=> "Criterio_92"],
            ["label"=> "Limpieza",                                          "name"=> "contra_93", "id"=>"contra_93", "hidden"=> "Criterio_93"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Estado y desgaste de caucho de ruedas de carga",                   "name"=> "comb_63", "id"=>"comb_63", "hidden"=> "Criterio_63"],
            ["label"=> "Estado y desgaste de caucho de ruedas de dirección",               "name"=> "comb_64", "id"=>"comb_64", "hidden"=> "Criterio_64"],
            ["label"=> "Estado de rin de carga",                                           "name"=> "comb_65", "id"=>"comb_65", "hidden"=> "Criterio_65"],
            ["label"=> "Estado de rin de dirección",                                       "name"=> "comb_66", "id"=>"comb_66", "hidden"=> "Criterio_66"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Estado de los rines",             "name"=> "manlift_87", "id"=>"manlift_87", "hidden"=> "Criterio_87"],
            ["label"=> "Estado de ruedas",                "name"=> "manlift_88", "id"=>"manlift_88", "hidden"=> "Criterio_88"],
            ["label"=> "Presión de neumáticos",           "name"=> "manlift_89", "id"=>"manlift_89", "hidden"=> "Criterio_89"]
        ]
    ],
    "Luces"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Luces frontales",               "name"=> "pasillo_106", "id"=>"pasillo_106", "hidden"=> "Criterio_106"],
            ["label"=> "Luz estroboscopia",             "name"=> "pasillo_107", "id"=>"pasillo_107", "hidden"=> "Criterio_107"],
            ["label"=> "Blue light",                    "name"=> "pasillo_108", "id"=>"pasillo_108", "hidden"=> "Criterio_108"],
            ["label"=> "Pito bocina",                   "name"=> "pasillo_109", "id"=>"pasillo_109", "hidden"=> "Criterio_109"],
            ["label"=> "Alarma reversa",                "name"=> "pasillo_110", "id"=>"pasillo_110", "hidden"=> "Criterio_110"] 
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Luces frontales",          "name"=> "contra_94", "id"=>"contra_94", "hidden"=> "Criterio_94"],
            ["label"=> "Luz estroboscopia",        "name"=> "contra_95", "id"=>"contra_95", "hidden"=> "Criterio_95"],
            ["label"=> "Luz de freno",             "name"=> "contra_96", "id"=>"contra_96", "hidden"=> "Criterio_96"],
            ["label"=> "Blue light",               "name"=> "contra_97", "id"=>"contra_97", "hidden"=> "Criterio_97"],
            ["label"=> "Pito bocina",              "name"=> "contra_98", "id"=>"contra_98", "hidden"=> "Criterio_98"],
            ["label"=> "Alarma reversa",           "name"=> "contra_99", "id"=>"contra_99", "hidden"=> "Criterio_99"]
        ]
    ],
    "Aditamentos"=>[
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Side shift",             "name"=> "contra_100", "id"=>"contra_100", "hidden"=> "Criterio_100"],
            ["label"=> "Fork positioner",        "name"=> "contra_101", "id"=>"contra_101", "hidden"=> "Criterio_101"],
            ["label"=> "Clamp",                  "name"=> "contra_102", "id"=>"contra_102", "hidden"=> "Criterio_102"],
            ["label"=> "Cascade Tubular",        "name"=> "contra_103", "id"=>"contra_103", "hidden"=> "Criterio_103"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Side shift",                  "name"=> "comb_56", "id"=>"comb_56", "hidden"=> "Criterio_56"],
            ["label"=> "Fork positioner",             "name"=> "comb_57", "id"=>"comb_57", "hidden"=> "Criterio_57"],
            ["label"=> "Boom",                        "name"=> "comb_58", "id"=>"comb_58", "hidden"=> "Criterio_58"]
        ]
    ],
    "Cargador"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Inspeccion visual",       "name"=> "pasillo_115", "id"=>"pasillo_115", "hidden"=> "Criterio_115"],
            ["label"=> "Cables de potencia",      "name"=> "pasillo_116", "id"=>"pasillo_116", "hidden"=> "Criterio_116"],
            ["label"=> "Conector Anderson",       "name"=> "pasillo_117", "id"=>"pasillo_117", "hidden"=> "Criterio_117"],
            ["label"=> "Voltaje",                 "name"=> "pasillo_118", "id"=>"pasillo_118", "hidden"=> "Criterio_118"],
            ["label"=> "Amperaje",                "name"=> "pasillo_119", "id"=>"pasillo_119", "hidden"=> "Criterio_119"] 
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Inspeccion visual",        "name"=> "contra_104", "id"=>"contra_104", "hidden"=> "Criterio_104"],
            ["label"=> "Cables de potencia",       "name"=> "contra_105", "id"=>"contra_105", "hidden"=> "Criterio_105"],
            ["label"=> "Conector Anderson",        "name"=> "contra_106", "id"=>"contra_106", "hidden"=> "Criterio_106"],
            ["label"=> "Voltaje",                  "name"=> "contra_107", "id"=>"contra_107", "hidden"=> "Criterio_107"],
            ["label"=> "Amperaje",                 "name"=> "contra_108", "id"=>"contra_108", "hidden"=> "Criterio_108"],
            ["label"=> "Fusible",                  "name"=> "contra_109", "id"=>"contra_109", "hidden"=> "Criterio_109"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Estado",                 "name"=> "manlift_7", "id"=>"manlift_7", "hidden"=> "Criterio_7"],
            ["label"=> "Voltaje promedio",       "name"=> "manlift_8", "id"=>"manlift_8", "hidden"=> "Criterio_8"],
            ["label"=> "Cables de Potencia",     "name"=> "manlift_9", "id"=>"manlift_9", "hidden"=> "Criterio_9"],
            ["label"=> "Conector anderson",      "name"=> "manlift_10", "id"=>"manlift_10", "hidden"=> "Criterio_10"],
            ["label"=> "Amperaje",               "name"=> "manlift_11", "id"=>"manlift_11", "hidden"=> "Criterio_11"],
            ["label"=> "Fusibles",               "name"=> "manlift_12", "id"=>"manlift_12", "hidden"=> "Criterio_12"]
        ]
    ],
    "Revision"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Limpieza de equipo",           "name"=> "pasillo_120", "id"=>"pasillo_120", "hidden"=> "Criterio_120"],
            ["label"=> "Horómetro",                    "name"=> "pasillo_121", "id"=>"pasillo_121", "hidden"=> "Criterio_121"],
            ["label"=> "Etiquetas de seguridad",       "name"=> "pasillo_122", "id"=>"pasillo_122", "hidden"=> "Criterio_122"],
            ["label"=> "Limpieza área de trabajo",     "name"=> "pasillo_123", "id"=>"pasillo_123", "hidden"=> "Criterio_123"],
            ["label"=> "Manual de operaciones",        "name"=> "pasillo_124", "id"=>"pasillo_124", "hidden"=> "Criterio_124"],
            ["label"=> "Tapas",                        "name"=> "pasillo_125", "id"=>"pasillo_125", "hidden"=> "Criterio_125"],
            ["label"=> "Silla",                        "name"=> "pasillo_126", "id"=>"pasillo_126", "hidden"=> "Criterio_126"],
            ["label"=> "Cinturon de seguridad",        "name"=> "pasillo_127", "id"=>"pasillo_127", "hidden"=> "Criterio_127"],
            ["label"=> "Extintor",                     "name"=> "pasillo_128", "id"=>"pasillo_128", "hidden"=> "Criterio_128"] 
        ],
        // CONTRABALANCEADA
        "contrabalanceada" => [
            ["label"=> "Limpieza del equipo",        "name"=> "contra_110", "id"=>"contra_110", "hidden"=> "Criterio_110"],
            ["label"=> "Horómetro",                  "name"=> "contra_111", "id"=>"contra_111", "hidden"=> "Criterio_111"],
            ["label"=> "Etiquetas de seguridad",     "name"=> "contra_112", "id"=>"contra_112", "hidden"=> "Criterio_112"],
            ["label"=> "Limpieza área de trabajo",   "name"=> "contra_113", "id"=>"contra_113", "hidden"=> "Criterio_113"],
            ["label"=> "Manual de operaciones",      "name"=> "contra_114", "id"=>"contra_114", "hidden"=> "Criterio_114"],
            ["label"=> "Tapas",                      "name"=> "contra_115", "id"=>"contra_115", "hidden"=> "Criterio_115"],
            ["label"=> "Capó y amortiguador",        "name"=> "contra_116", "id"=>"contra_116", "hidden"=> "Criterio_116"],
            ["label"=> "Silla",                      "name"=> "contra_117", "id"=>"contra_117", "hidden"=> "Criterio_117"],
            ["label"=> "Cinturon de seguridad",      "name"=> "contra_118", "id"=>"contra_118", "hidden"=> "Criterio_118"],
            ["label"=> "Extintor",                   "name"=> "contra_119", "id"=>"contra_119", "hidden"=> "Criterio_119"]
        ],
        // COMBUSTION
        "combustion" => [
            ["label"=> "Limpieza de equipo",             "name"=> "comb_67", "id"=>"comb_67", "hidden"=> "Criterio_67"],
            ["label"=> "Horometro",                      "name"=> "comb_68", "id"=>"comb_68", "hidden"=> "Criterio_68"],
            ["label"=> "Etiquetas de seguridad",         "name"=> "comb_69", "id"=>"comb_69", "hidden"=> "Criterio_69"],
            ["label"=> "Limpieza area de trabajo",       "name"=> "comb_70", "id"=>"comb_70", "hidden"=> "Criterio_70"],
            ["label"=> "Manual de operaciones",          "name"=> "comb_71", "id"=>"comb_71", "hidden"=> "Criterio_71"],
            ["label"=> "Tapas",                          "name"=> "comb_72", "id"=>"comb_72", "hidden"=> "Criterio_72"],
            ["label"=> "Capó y amortiguador",            "name"=> "comb_73", "id"=>"comb_73", "hidden"=> "Criterio_73"],
            ["label"=> "Silla",                          "name"=> "comb_74", "id"=>"comb_74", "hidden"=> "Criterio_74"],
            ["label"=> "Cinturon de seguridad",          "name"=> "comb_75", "id"=>"comb_75", "hidden"=> "Criterio_75"],
            ["label"=> "Extintor",                       "name"=> "comb_76", "id"=>"comb_76", "hidden"=> "Criterio_76"]
        ]
    ],
    "Auxiliares"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Motor de funciones auxiliares",             "name"=> "pasillo_42", "id"=>"pasillo_42", "hidden"=> "Criterio_42"],
            ["label"=> "Escobillas",                                "name"=> "pasillo_43", "id"=>"pasillo_43", "hidden"=> "Criterio_43"],
            ["label"=> "Bomba de funciones auxiliares",             "name"=> "pasillo_44", "id"=>"pasillo_44", "hidden"=> "Criterio_44"],
            ["label"=> "Generador de torque",                       "name"=> "pasillo_45", "id"=>"pasillo_45", "hidden"=> "Criterio_45"],
            ["label"=> "Orbitrol",                                  "name"=> "pasillo_46", "id"=>"pasillo_46", "hidden"=> "Criterio_46"],
            ["label"=> "Mangueras",                                 "name"=> "pasillo_47", "id"=>"pasillo_47", "hidden"=> "Criterio_47"]
        ]
    ],
    "Suspension"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Pasador",             "name"=> "pasillo_48", "id"=>"pasillo_48", "hidden"=> "Criterio_48"],
            ["label"=> "Rodamientos",         "name"=> "pasillo_49", "id"=>"pasillo_49", "hidden"=> "Criterio_49"],
            ["label"=> "Tornilleria",         "name"=> "pasillo_50", "id"=>"pasillo_50", "hidden"=> "Criterio_50"],
            ["label"=> "Suspensión",          "name"=> "pasillo_51", "id"=>"pasillo_51", "hidden"=> "Criterio_51"],
            ["label"=> "Pines",               "name"=> "pasillo_52", "id"=>"pasillo_52", "hidden"=> "Criterio_52"],
            ["label"=> "Amortiguador",        "name"=> "pasillo_53", "id"=>"pasillo_53", "hidden"=> "Criterio_53"]
        ]
    ],
    "Pantografo"=>[
        //PASILLO
        "pasillo" => [
            ["label"=> "Ajuste de pantógrafo",               "name"=> "pasillo_80", "id"=>"pasillo_80", "hidden"=> "Criterio_80"],
            ["label"=> "Rodamientos",                        "name"=> "pasillo_81", "id"=>"pasillo_81", "hidden"=> "Criterio_81"],
            ["label"=> "Cadenas",                            "name"=> "pasillo_82", "id"=>"pasillo_82", "hidden"=> "Criterio_82"],
            ["label"=> "Pasadores",                          "name"=> "pasillo_83", "id"=>"pasillo_83", "hidden"=> "Criterio_83"],
            ["label"=> "Parilla (espejo)",                   "name"=> "pasillo_84", "id"=>"pasillo_84", "hidden"=> "Criterio_84"],
            ["label"=> "Mordazas",                           "name"=> "pasillo_85", "id"=>"pasillo_85", "hidden"=> "Criterio_85"],
            ["label"=> "Deslizadores",                       "name"=> "pasillo_86", "id"=>"pasillo_86", "hidden"=> "Criterio_86"],
            ["label"=> "Bloque de tilt down",                "name"=> "pasillo_87", "id"=>"pasillo_87", "hidden"=> "Criterio_87"],
            ["label"=> "Mangueras",                          "name"=> "pasillo_88", "id"=>"pasillo_88", "hidden"=> "Criterio_88"],
            ["label"=> "Topes de reach (caucho)",            "name"=> "pasillo_89", "id"=>"pasillo_89", "hidden"=> "Criterio_89"]
        ]
    ],
    "Motor"=>[
        // COMBUSTION
        "combustion" => [
            ["label"=> "Estado de cables de alta",               "name"=> "comb_15", "id"=>"comb_15", "hidden"=> "Criterio_15"],
            ["label"=> "Tapa de distribuidor",                   "name"=> "comb_16", "id"=>"comb_16", "hidden"=> "Criterio_16"],
            ["label"=> "Rotor o escobilla",                      "name"=> "comb_17", "id"=>"comb_17", "hidden"=> "Criterio_17"],
            ["label"=> "Módulo",                                 "name"=> "comb_18", "id"=>"comb_18", "hidden"=> "Criterio_18"],
            ["label"=> "Filtro de aceite",                       "name"=> "comb_19", "id"=>"comb_19", "hidden"=> "Criterio_19"],
            ["label"=> "Varilla (baqueta o bayoneta)",           "name"=> "comb_20", "id"=>"comb_20", "hidden"=> "Criterio_20"],
            ["label"=> "Soportes de motor",                      "name"=> "comb_21", "id"=>"comb_21", "hidden"=> "Criterio_21"],
            ["label"=> "Nivel de aceite de motor",               "name"=> "comb_22", "id"=>"comb_22", "hidden"=> "Criterio_22"]
        ]
    ],
    "Refrigeracion"=>[
        // COMBUSTION
        "combustion" => [
            ["label"=> "Radiador",                         "name"=> "comb_23", "id"=>"comb_23", "hidden"=> "Criterio_23"],
            ["label"=> "Correa de accesorios",             "name"=> "comb_24", "id"=>"comb_24", "hidden"=> "Criterio_24"],
            ["label"=> "Ventilador",                       "name"=> "comb_25", "id"=>"comb_25", "hidden"=> "Criterio_25"],
            ["label"=> "Bomba de agua",                    "name"=> "comb_26", "id"=>"comb_26", "hidden"=> "Criterio_26"],
            ["label"=> "Nivel de líquido refrigerante",    "name"=> "comb_27", "id"=>"comb_27", "hidden"=> "Criterio_27"],
            ["label"=> "Manguera superior e inferior",     "name"=> "comb_28", "id"=>"comb_28", "hidden"=> "Criterio_28"],
            ["label"=> "Tapa de radiador de 13 (psi)",     "name"=> "comb_29", "id"=>"comb_29", "hidden"=> "Criterio_29"]
        ]
    ],
    "Combustion"=>[
        // COMBUSTION
        "combustion" => [
            ["label"=> "Estado del carburador",                        "name"=> "comb_30", "id"=>"comb_30", "hidden"=> "Criterio_30"],
            ["label"=> "Regulador de gas",                             "name"=> "comb_31", "id"=>"comb_31", "hidden"=> "Criterio_31"],
            ["label"=> "Filtro de aire",                               "name"=> "comb_32", "id"=>"comb_32", "hidden"=> "Criterio_32"],
            ["label"=> "Filtro del regulador de gas",                  "name"=> "comb_33", "id"=>"comb_33", "hidden"=> "Criterio_33"],
            ["label"=> "Estado de bujías",                             "name"=> "comb_34", "id"=>"comb_34", "hidden"=> "Criterio_34"],
            ["label"=> "Funcionamiento de la bomba de gasolina",       "name"=> "comb_35", "id"=>"comb_35", "hidden"=> "Criterio_35"]
        ]
    ],
    "Transmision"=>[
        // COMBUSTION
        "combustion" => [
            ["label"=> "Nivel de valvulina",            "name"=> "comb_36", "id"=>"comb_36", "hidden"=> "Criterio_36"],
            ["label"=> "Fugas",                         "name"=> "comb_37", "id"=>"comb_37", "hidden"=> "Criterio_37"],
            ["label"=> "Tornilleria",                   "name"=> "comb_38", "id"=>"comb_38", "hidden"=> "Criterio_38"]
        ]
    ],
    "Caja"=>[
        // COMBUSTION
        "combustion" => [
            ["label"=> "Nivel de aceite",                  "name"=> "comb_93", "id"=>"comb_93", "hidden"=> "Criterio_93"],
            ["label"=> "Filtro",                           "name"=> "comb_94", "id"=>"comb_94", "hidden"=> "Criterio_94"],
            ["label"=> "electroválvulas",                  "name"=> "comb_95", "id"=>"comb_95", "hidden"=> "Criterio_95"],
            ["label"=> "Mangueras de refrigeración",       "name"=> "comb_96", "id"=>"comb_96", "hidden"=> "Criterio_96"],
            ["label"=> "Convertidor de torque",            "name"=> "comb_97", "id"=>"comb_97", "hidden"=> "Criterio_97"],
            ["label"=> "Cardán",                           "name"=> "comb_98", "id"=>"comb_98", "hidden"=> "Criterio_98"]
        ]
    ],
    "Componentes"=>[
        // MANLIFT
        "manlift" => [
            ["label"=> "Estado del chasis-bastidor",           "name"=> "manlift_39", "id"=>"manlift_39", "hidden"=> "Criterio_39"],
            ["label"=> "Estructura extensible",                "name"=> "manlift_40", "id"=>"manlift_40", "hidden"=> "Criterio_40"],
            ["label"=> "Estado de la plataforma",              "name"=> "manlift_41", "id"=>"manlift_41", "hidden"=> "Criterio_41"],
            ["label"=> "Estado del punto de anclaje",          "name"=> "manlift_42", "id"=>"manlift_42", "hidden"=> "Criterio_42"]
        ]
    ],
    "Ausencia"=>[
        // MANLIFT
        "manlift" => [
            ["label"=> "Pasadores",               "name"=> "manlift_43", "id"=>"manlift_43", "hidden"=> "Criterio_43"],
            ["label"=> "Cojinetes",               "name"=> "manlift_44", "id"=>"manlift_44", "hidden"=> "Criterio_44"],
            ["label"=> "Ejes",                    "name"=> "manlift_45", "id"=>"manlift_45", "hidden"=> "Criterio_45"],
            ["label"=> "Corona de giro",          "name"=> "manlift_46", "id"=>"manlift_46", "hidden"=> "Criterio_46"],
            ["label"=> "Motor de giro",           "name"=> "manlift_47", "id"=>"manlift_47", "hidden"=> "Criterio_47"],
            ["label"=> "Rodillos",                "name"=> "manlift_48", "id"=>"manlift_48", "hidden"=> "Criterio_48"],
            ["label"=> "Puntos de anclaje",       "name"=> "manlift_49", "id"=>"manlift_49", "hidden"=> "Criterio_49"],
            ["label"=> "Pernos",                  "name"=> "manlift_50", "id"=>"manlift_50", "hidden"=> "Criterio_50"],
            ["label"=> "Tuercas",                 "name"=> "manlift_51", "id"=>"manlift_51", "hidden"=> "Criterio_51"],
            ["label"=> "Remaches",                "name"=> "manlift_52", "id"=>"manlift_52", "hidden"=> "Criterio_52"]
        ]
    ],
    "Revisiones"=>[
        // MANLIFT
        "manlift" => [
            ["label"=> "Medidor horas",                                       "name"=> "manlift_64", "id"=>"manlift_64", "hidden"=> "Criterio_64"],
            ["label"=> "Extintores",                                          "name"=> "manlift_65", "id"=>"manlift_65", "hidden"=> "Criterio_65"],
            ["label"=> "Bocina",                                              "name"=> "manlift_66", "id"=>"manlift_66", "hidden"=> "Criterio_66"],
            ["label"=> "Luces indicadoras",                                   "name"=> "manlift_67", "id"=>"manlift_67", "hidden"=> "Criterio_67"],
            ["label"=> "Desconector de emergencia",                           "name"=> "manlift_68", "id"=>"manlift_68", "hidden"=> "Criterio_68"],
            ["label"=> "Operación de controles",                              "name"=> "manlift_69", "id"=>"manlift_69", "hidden"=> "Criterio_69"],
            ["label"=> "Frenado",                                             "name"=> "manlift_70", "id"=>"manlift_70", "hidden"=> "Criterio_70"],
            ["label"=> "Control manual en tierra",                            "name"=> "manlift_71", "id"=>"manlift_71", "hidden"=> "Criterio_71"],
            ["label"=> "Control manual en canastilla",                        "name"=> "manlift_72", "id"=>"manlift_72", "hidden"=> "Criterio_72"],
            ["label"=> "Señalización de mandos de tierra",                    "name"=> "manlift_73", "id"=>"manlift_73", "hidden"=> "Criterio_73"],
            ["label"=> "Señalización de mandos en plataforma",                "name"=> "manlift_74", "id"=>"manlift_74", "hidden"=> "Criterio_74"]
        ]
    ],
    "Funcionamiento"=>[
        // MANLIFT
        "manlift" =>[
            ["label"=> "Funcionamiento",      "name"=> "manlift_75", "id"=>"manlift_75", "hidden"=> "Criterio_75"]
        ]
    ],
    "Correas"=>[
        // MANLIFT
        "manlift" => [
            ["label"=> "Chequear ajustes",                                "name"=> "manlift_82", "id"=>"manlift_82", "hidden"=> "Criterio_82"],
            ["label"=> "Ausencia de corrosión",                           "name"=> "manlift_83", "id"=>"manlift_83", "hidden"=> "Criterio_83"],
            ["label"=> "Ausencia de corte",                               "name"=> "manlift_84", "id"=>"manlift_84", "hidden"=> "Criterio_84"],
            ["label"=> "Ausencia de deformaciones en eslabones",          "name"=> "manlift_85", "id"=>"manlift_85", "hidden"=> "Criterio_85"],
            ["label"=> "Ausencia de pasadores desencajados",              "name"=> "manlift_86", "id"=>"manlift_86", "hidden"=> "Criterio_86"]
        ]
    ],
    "Unidad"=>[
        // MANLIFT
        "manlift" => [
            ["label"=> "Nivel de aceite",          "name"=> "manlift_90", "id"=>"manlift_90", "hidden"=> "Criterio_90"],
            ["label"=> "Fugas",                    "name"=> "manlift_91", "id"=>"manlift_91", "hidden"=> "Criterio_91"],
            ["label"=> "Conexiones de cables",     "name"=> "manlift_92", "id"=>"manlift_92", "hidden"=> "Criterio_92"],
            ["label"=> "Motor tracción",           "name"=> "manlift_93", "id"=>"manlift_93", "hidden"=> "Criterio_93"]
        ]
    ],
    "Panel"=>[
        // MANLIFT
        "manlift" => [
            ["label"=> "Controladores en marcha",                   "name"=> "manlift_94", "id"=>"manlift_94", "hidden"=> "Criterio_94"],
            ["label"=> "Switches de marcha",                        "name"=> "manlift_95", "id"=>"manlift_95", "hidden"=> "Criterio_95"],
            ["label"=> "Contractores hidráulicos",                  "name"=> "manlift_96", "id"=>"manlift_96", "hidden"=> "Criterio_96"],
            ["label"=> "Switches hidráulicos",                      "name"=> "manlift_97", "id"=>"manlift_97", "hidden"=> "Criterio_97"],
            ["label"=> "Mandos en el tablero de la canastilla",     "name"=> "manlift_98", "id"=>"manlift_98", "hidden"=> "Criterio_98"],
            ["label"=> "Sensor de persona en canastilla",           "name"=> "manlift_99", "id"=>"manlift_99", "hidden"=> "Criterio_99"]
        ]
    ],
    "Pintura"=>[
         // PASILLO ANGOSTO
        "pasillo" => [
            ["label"=> "Estado general de pintura del chasís",                  "name"=> "pasillo_129", "id"=>"pasillo_129", "hidden"=> "Criterio_129"],
            ["label"=> "Pintura en mástil y secciones móviles",                 "name"=> "pasillo_130", "id"=>"pasillo_130", "hidden"=> "Criterio_130"],
            ["label"=> "Pintura en protecciones laterales y cubiertas",         "name"=> "pasillo_131", "id"=>"pasillo_131", "hidden"=> "Criterio_131"]
        ],
        // CONTRABALANCEADA ELÉCTRICA
        "contrabalanceada" => [
            ["label"=> "Estado general de pintura del chasís",                  "name"=> "contra_120", "id"=>"contra_120", "hidden"=> "Criterio_120"],
            ["label"=> "Pintura en mástil y secciones",                         "name"=> "contra_121", "id"=>"contra_121", "hidden"=> "Criterio_121"],
            ["label"=> "Pintura en contrapeso",                                 "name"=> "contra_122", "id"=>"contra_122", "hidden"=> "Criterio_122"]
        ],
        // COMBUSTIÓN
        "combustion" => [
            ["label"=> "Estado general de pintura del chasís",                  "name"=> "comb_106", "id"=>"comb_106", "hidden"=> "Criterio_106"],
            ["label"=> "Pintura en mástil y secciones",                         "name"=> "comb_107", "id"=>"comb_107", "hidden"=> "Criterio_107"],
            ["label"=> "Pintura en contrapeso y cubierta del motor",            "name"=> "comb_108", "id"=>"comb_108", "hidden"=> "Criterio_108"]
        ],
        // MANLIFT
        "manlift" => [
            ["label"=> "Estado de pintura en plataforma y barandas",            "name"=> "manlift_100", "id"=>"manlift_100", "hidden"=> "Criterio_100"],
            ["label"=> "Pintura de base, brazos y estructura",                  "name"=> "manlift_101", "id"=>"manlift_101", "hidden"=> "Criterio_101"]
        ]
    ],
    
];

echo json_encode($Criterios, JSON_UNESCAPED_UNICODE);
?>