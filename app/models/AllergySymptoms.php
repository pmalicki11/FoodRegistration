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
      self::FOOD => 'Digestive issues - vomiting, diarrhea, heartburn, constipation, belching, nausea, abdominal bloating, abdominal pain',
      self::ORAL => 'Oral discomfort - burning and stinging in the oral cavity, swelling of the lips',
      self::SKIN => 'Skin issues - rashes, itching, atopic dermatitis',
      self::NOSE => 'Nasal issues - runny nose, nasal congestion, sinus problems',
      self::HEAD => 'Head-related symptoms - headache, dizziness',
      self::LUNG => 'Respiratory issues - cough, shortness of breath, wheezing, hoarseness',
      self::EYES => 'Eye-related symptoms - tearing, burning',
      self::SHOC => 'Anaphylactic shock'
    ];

    public static function getDescription($symptomCode) {
      return self::$_descriptions[$symptomCode] ?? '';
    }

    public static function getAll() {
      return self::$_descriptions;
    }
  }