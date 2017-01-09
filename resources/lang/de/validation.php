<?php
	/*****
	 * Created by PhpStorm.
	 * User: Yannick
	 * Date: 09.01.2017
	 * Time: 20:11
	 * validation.php
	 *****/

	return [

		/*
		|--------------------------------------------------------------------------
		| Validation Language Lines
		|--------------------------------------------------------------------------
		|
		| The following language lines contain the default error messages used by
		| the validator class. Some of these rules have multiple versions such
		| as the size rules. Feel free to tweak each of these messages here.
		|
		*/

		'accepted'             => ':attribute muss aktzeptiert werden.',
		'active_url'           => ':attribute ist keine gültige URL.',
		'after'                => 'Der :attribute muss ein Datum nach dem :date sein.',
		'alpha'                => ':attribute darf nur Buchstaben enthalten.',
		'alpha_dash'           => ':attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.',
		'alpha_num'            => ':attribute dar nur Buchstaben und Zahlen enthalten.',
		'array'                => ':attribute muss eine Liste sein.',
		'before'               => ':attribute muss ein Datum vor dem :date sein.',
		'between'              => [
			'numeric' => ':attribute muss zwischen :min und :max liegen.',
			'file'    => ':attribute muss zwischen :min und :max Kilobyte liegen.',
			'string'  => ':attribute muss zwischen :min und :max Zeichen beinhalten.',
			'array'   => ':attribute muss zwischen :min und :max Items beinhalten.',
		],
		'boolean'              => ':attribute kann nur wahr oder falsch sein.',
		'confirmed'            => 'Die Bestätigung von :attribute stimmt nicht über ein.',
		'date'                 => ':attribute ist kein gültiges Datum.',
		'date_format'          => ':attribute stimmt nicht mit dem gewünschten Format überein :format.',
		'different'            => ':attribute und :other müssen sich unterscheiden.',
		'digits'               => ':attribute muss aus :digits Ziffern bestehen.',
		'digits_between'       => 'Die Ziffern in :attribute müssen zwischen :min und :max liegen.',
		'email'                => ':attribute muss eine gültige E-Mail-Adresse sein.',
		'exists'               => 'Das ausgewählte Attribut :attribute ist ungültig.',
		'filled'               => ':attribute ist ein Pflichtfeld.',
		'image'                => ':attribute muss ein Bild sein.',
		'in'                   => 'Das gewählte Attribut :attribute ist ungültig.',
		'integer'              => ':attribute muss eine gültige ganze Zahl sein.',
		'ip'                   => ':attribute muss eine valide IP-Adresse sein.',
		'json'                 => ':attribute muss ein gültiger JSON String sein.',
		'max'                  => [
			'numeric' => ':attribute darf nicht größer als :max sein.',
			'file'    => ':attribute darf nicht größer als :max Kilobyte sein.',
			'string'  => ':attribute darf :max Zeichen nicht überschreiten.',
			'array'   => ':attribute darf nicht mehr als :max Items enthalten.',
		],
		'mimes'                => ':attribute muss vom Typ: :values sein.',
		'min'                  => [
			'numeric' => ':attribute muss mindestens :min betragen.',
			'file'    => ':attribute muss mindestens :min Kilobyte groß sein.',
			'string'  => ':attribute muss mindestens :min Zeichen lang sein.',
			'array'   => ':attribute muss mindestens :min Items beinhalten.',
		],
		'not_in'               => 'Die Selektion von :attribute ist ungültig.',
		'numeric'              => ':attribute muss eine Nummer sein.',
		'regex'                => 'Das Format von :attribute ist ungültig.',
		'required'             => ':attribute ist ein Pflichtfeld.',
		'required_if'          => ':attribute wird benötigt, wenn :other in :value enthalten ist.',
		'required_unless'      => ':attribute wird benötigt solange :other nicht in :values enthalten ist.',
		'required_with'        => ':attribute ist benötigt wenn ein Wert in :values enthalten ist.',
		'required_with_all'    => ':attribute ist benötigt wenn Werte in :values enthalten sind.',
		'required_without'     => ':attribute wird benötigt, wenn keine Wert in :values vorhanden ist.',
		'required_without_all' => ':attribute wird benötigt, wenn keine Werte in :values vorhanden sind.',
		'same'                 => ':attribute und :other müssen zusammen passen.',
		'size'                 => [
			'numeric' => ':attribute muss :size sein.',
			'file'    => ':attribute muss :size Kilobyte groß sein.',
			'string'  => ':attribute muss mindestens :size Zeichen langs ein.',
			'array'   => ':attribute muss mindestens :size Items beinhalten.',
		],
		'string'               => ':attribute muss ein Text sein.',
		'timezone'             => ':attribute muss eine gültige Zeitzone sein.',
		'unique'               => ':attribute wurde bereits vergeben.',
		'url'                  => 'Das Format von :attribute ist ungültig.',

		/*
		|--------------------------------------------------------------------------
		| Custom Validation Language Lines
		|--------------------------------------------------------------------------
		|
		| Here you may specify custom validation messages for attributes using the
		| convention "attribute.rule" to name the lines. This makes it quick to
		| specify a specific custom language line for a given attribute rule.
		|
		*/

		'custom' => [
			'attribute-name' => [
				'rule-name' => 'custom-message',
			],
		],

		/*
		|--------------------------------------------------------------------------
		| Custom Validation Attributes
		|--------------------------------------------------------------------------
		|
		| The following language lines are used to swap attribute place-holders
		| with something more reader friendly such as E-Mail Address instead
		| of "email". This simply helps us make messages a little cleaner.
		|
		*/

		'attributes' => [],

	];
