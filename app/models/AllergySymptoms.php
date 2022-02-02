<?php

  class AllergySymptoms {

    public const FOOD = 1;
    public const ORAL = 2;
    public const SKIN = 3;
    public const NOSE = 4;
    public const HEAD = 5;
    public const LUNG = 6;
    public const EYES = 7;
    public const SHOC = 8;

    private static $_descriptions = [
      self::FOOD => 'Dolegliwości pokarmowe - wymioty, biegunki, zgaga, zaparcia, odbijanie, mdłości, wzdęcia brzucha, bóle brzucha',
      self::ORAL => 'Dolegliwości jamy ustnej - pieczenie i szczypanie w obrębie jamy ustnej, obrzęk warg',
      self::SKIN => 'Dolegliwości skóry - wypryski, swędzenie, atopowe zapalenie skóry',
      self::NOSE => 'Dolegliwości nosa - katar, zatkany nos i zatoki',
      self::HEAD => 'Dolegliwości głowy - ból, zawroty',
      self::LUNG => 'Dolegliwości oddechowe - kaszel, duszności, skrócony lub świszczący oddech, chrypka',
      self::EYES => 'Doleglowości oczu - łzawienie, pieczenie',
      self::SHOC => 'Wstrząs anafilaktyczny'
    ];

    public static function getDescription($symptomCode) {
      return self::$_descriptions[$symptomCode] ?? '';
    }

    public static function getAll() {
      return self::$_descriptions;
    }
  }