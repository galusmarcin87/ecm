<?php
return [
    'sections' => [
        [
            'name' => 'CZĘŚĆ I: DOŚWIADCZENIE',
            'questions' => [
                [
                    'question' => 'Posiadane przez Pana/Panią wykształcenie?',
                    'answers' => [
                        'Wyższe',
                        'Inne wyższe',
                        'Średnie ekonomiczne',
                        'Inne średnie',
                        'Podstawowe'
                    ]
                ],
                [
                    'question' => 'Proszę o wskazanie zawodu najbardziej zbliżonego do Pana/Pani profesji:',
                    'answers' => [
                        'Kadra kierownicza',
                        'Przedsiębiorca',
                        'Urzędnik państwowy',
                        'Specjalista w sektorze usług finansowych',
                        'Specjalista w sektorze innym niż usługi finansowe',
                        'Emeryt/rencista',
                        'Pracownik fizyczny',
                        'Inny zawód',
                        'Bezrobotny'
                    ]
                ],
                [
                    'question' => 'Czy wykonuje Pan/Pani obecnie lub wykonywał/a w przeszłości zawód związany z rynkiem finansowym?',
                    'answers' => [
                        'Nie wykonywałem/am i nie wykonuję',
                        'Wykonywałem/am bądź wykonuję krócej niż rok',
                        'Wykonywałem/am bądź wykonuję ponad rok'
                    ]
                ],
                [
                    'question' => 'Czy wykonuje Pan/Pani obecnie lub wykonywał/a w przeszłości zawód związany z finansowaniem społecznościowym?',
                    'answers' => [
                        'Nie wykonywałem/am i nie wykonuję',
                        'Wykonywałem/am bądź wykonuję krócej niż rok',
                        'Wykonywałem/am bądź wykonuję ponad rok'
                    ]
                ],
                [
                    'question' => 'W jakiego typu aktywa dokonał/a Pan/Pani inwestycji w ciągu ostatnich trzech lat?',
                    'isCheckbox' => true,
                    'answers' => [
                        'Nieruchomości',
                        'Obligacje skarbowe',
                        'Akcje lub obligacje notowane na rynku giełdowym',
                        'Akcje lub udziały spółek niepublicznych',
                        'Weksle inwestycyjne',
                        'Kryptoaktywa',
                        'Pożyczki',
                        'Certyfikaty inwestycyjne funduszu inwestycyjnego zamkniętego',
                        'Jednostki uczestnictwa otwartego lub specjalistycznego funduszu inwestycyjnego otwartego',
                        'Obligacje korporacyjne nienotowane na rynku giełdowym',
                        'Żadne z powyższych'
                    ]
                ],
                [
                    'question' => 'Czy w ciągu ostatnich trzech lat dokonał/a Pan/ Pani inwestycji w instrumenty dopuszczone na potrzeby finansowania społecznościowego?',
                    'answers' => [
                        'Tak, w akcje lub udziały spółek oferowane za pośrednictwem platform finansowania społecznościowego',
                        'Tak, w inne zbywalne papiery wartościowe oferowane za pośrednictwem platform finansowania społecznościowego',
                        'Tak, w pożyczki oferowane za pośrednictwem platform finansowania społecznościowego',
                        'Nie'
                    ],
                    'subquestions' => [
                        [
                            'question' => 'Jaką łączną kwotę Pan/Pani zainwestował/a w instrumenty dopuszczone na potrzeby finansowania społecznościowego?',
                            'answers' => [
                                'Poniżej 10 000 zł',
                                '10 000 zł - 100 000 zł',
                                'Powyżej 100 000 zł'
                            ]
                        ],
                        [
                            'question' => 'Ile inwestycji w instrumenty dopuszczone na potrzeby finansowania społecznościowego dokonał/a Pan/Pani w ciągu ostatnich trzech lat?',
                            'answers' => [
                                '1-3',
                                '4-10',
                                'Powyżej 10'
                            ]
                        ],
                    ]
                ],

            ]
        ],
        [
            'name' => 'CZĘŚĆ II: WIEDZA I ZROZUMIENIE RYZYKA',
            'questions' => [
                [
                    'question' => 'Niedopuszczone do obrotu na rynku regulowanym papiery wartościowe na ogół charakteryzują się niską płynnością:',
                    'answers' => ['Tak', 'Nie', 'Nie wiem']
                ],
                [
                    'question' => 'Historyczne wyniki finansowe spółek stanowią gwarancję uzyskania podobnych wyników w przyszłości',
                    'answers' => ['Tak', 'Nie', 'Nie wiem']
                ],
                [
                    'question' => 'Czy inwestycja w instrumenty dopuszczone na potrzeby finansowania społecznościowego objęta jest systemem gwarancji depozytów?',
                    'answers' => ['Tak', 'Nie', 'Nie wiem']
                ],
                [
                    'question' => 'Który/e z poniższych dokumentów podlegają obowiązkowemu zatwierdzeniu przez Komisję Nadzoru Finansowego:',
                    'answers' => ['Prospekt', 'Arkusz kluczowych informacji inwestycyjnych', 'Propozycja nabycia obligacji', 'Żaden z powyższych']
                ],
                [
                    'question' => 'Czy inwestowanie w produkty dopuszczone na potrzeby finansowania społecznościowego wiąże się z ryzykiem utraty całości zainwestowanego kapitału?',
                    'answers' => ['Tak', 'Nie, nie wiąże się z żadnym ryzykiem', 'Nie, wiąże się z ryzykiem utraty wyłącznie części zainwestowanego kapitału']
                ],
                [
                    'question' => 'Czy możliwość osiągnięcia wyższych zysków wiąże się, co do zasady, z wyższym ryzykiem poniesienia straty?',
                    'answers' => ['Tak', 'Nie', 'Nie wiem']
                ],
                [
                    'question' => 'Na czym polega dywersyfikacja inwestycji?',
                    'answers' => ['Na podziale zainwestowanego kapitału w różne rodzaje aktywów', 'Na wypłacie zysku z inwestycji', 'Nie wiem']
                ],
                [
                    'question' => 'Które z poniższych papierów wartościowych nie mają charakteru dłużnego?',
                    'answers' => ['Obligacje', 'Akcje', 'Certyfikaty inwestycyjne', 'Weksle', 'Nie wiem']
                ],
                [
                    'question' => 'Akcje spółek publicznych, notowane na giełdzie papierów wartościowych można?',
                    'answers' => ['Sprzedać na giełdzie po cenie co najmniej równej całej zainwestowanej kwocie', 'Sprzedać na giełdzie, przy czym kwota uzyskana ze sprzedaży może być znacząco niższa od kwoty zainwestowanych środków', 'Odsprzedać w każdej chwili emitentowi niezależnie od płynności na rynku giełdowym', 'Nie wiem']
                ],
                [
                    'question' => 'Czy akcjonariusz, który nabył akcje za pośrednictwem platformy finansowania społecznościowego ma zawsze zagwarantowane prawo do dywidendy z posiadanych akcji?',
                    'answers' => ['Tak', 'Tak, ale tylko przez okres 3 lat', 'Nie', 'Nie wiem']
                ],
            ]
        ],

    ],


];
