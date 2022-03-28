<?php

namespace local_pr_graduates\services\setting;

use admin_setting_configtextarea;

class admin_setting_localization_list extends admin_setting_configtextarea {

	/**
	 * @param $data
	 * @return bool|string
	 */
	public function validate($data) {
		foreach (preg_split('/\n|\r\n?\s*/', $data) as $item) {
			if (count(explode('|', trim($item))) !== 3) {
				return "В строке {$item} допущена ошибка!";
			}
		}
		return true;
	}

	public function write_setting($data) {
		if (!$data) {
			$data = $this->get_new_default_setting();
		}
		return parent::write_setting($data);
	}

	/**
	 * @return string
	 */
	public function get_new_default_setting(): string {
		return
"first_tab|Информация о выпуске|ru
second_tab|Личная информация|ru
third_tab|Библиотека|ru
GodVypuska|Год выпуска|ru
GodVypuska|GodVypuska|en
Fakultet|Факультет|ru
Fakultet|Fakultet|en
Programma|Программа|ru
Programma|Programma|en
Spetsializatsiya|Специализация|ru
Spetsializatsiya|Spetsializatsiya|en
UrovenPodgotovki|Уровень подготовки|ru
UrovenPodgotovki|UrovenPodgotovki|en
TemaVKR|Тема ВКР|ru
TemaVKR|TemaVKR|en
NauchnyyRukovoditelVKR|Научный руководитель ВКР|ru
NauchnyyRukovoditelVKR|NauchnyyRukovoditelVKR|en
KlyuchevyeSlovaVKR|Ключевые  слова ВКР|ru
KlyuchevyeSlovaVKR|KlyuchevyeSlovaVKR|en
FamiliyaPrezhnyaya|Прежняя фамилия|ru
FamiliyaPrezhnyaya|FamiliyaPrezhnyaya|en
Kontaktnost|Kontaktnost|ru
Kontaktnost|Kontaktnost|en
Organizatsiya|Организация|ru
Organizatsiya|Organizatsiya|en
Dolzhnost|Должность/сфера|ru
Dolzhnost|Dolzhnost|en
SposobKontaktaDogovorennosti|Способ контакта|ru
SposobKontaktaDogovorennosti|SposobKontaktaDogovorennosti|en
Gorod|Город|ru
Gorod|Gorod|en
Region|Регион|ru
Region|Region|en
Facebook|Facebook|ru
Facebook|Facebook|en
AktualnayaPochta|Актуальная почта|ru
AktualnayaPochta|AktualnayaPochta|en
EMail|Почта запасная|ru
EMail|EMail|en
AktualnyyTelefon|Актуальный телефон|ru
AktualnyyTelefon|AktualnyyTelefon|en
Telefon|Телефон запасной|ru
Telefon|Telefon|en
Rassylka|Рассылка|ru
Rassylka|Rassylka|en
PropuskVBiblioteku|Постоянный пропуск в библиотеку|ru
PropuskVBiblioteku|PropuskVBiblioteku|en
Sayt|Сайт|ru
Sayt|Sayt|en
StranitsaNaSayteShaninki|Страница на сайте Шанинки|ru
StranitsaNaSayteShaninki|StranitsaNaSayteShaninki|en
NikTelegram|Ник в Telegram|ru
NikTelegram|NikTelegram|en
KanalyTelegramInstagram|Каналы в Telegram или Instagram|ru
KanalyTelegramInstagram|KanalyTelegramInstagram|en
OtzyvPoItogamObucheniya|Отзыв по итогам обучения (анкета)|ru
OtzyvPoItogamObucheniya|OtzyvPoItogamObucheniya|en
PozhelaniyaPoDalneysheyAktivnosti|Пожелания по дальнейшей активности|ru
PozhelaniyaPoDalneysheyAktivnosti|PozhelaniyaPoDalneysheyAktivnosti|en
ProdolzhenieAkademicheskoyKarery|Продолжение академической карьеры|ru
ProdolzhenieAkademicheskoyKarery|ProdolzhenieAkademicheskoyKarery|en
Interesy|Интересы|ru
Interesy|Interesy|en
NetVZhivykh|NetVZhivykh|ru
NetVZhivykh|NetVZhivykh|en
ZapreshchenoRedaktirovanieVypusknikom|ZapreshchenoRedaktirovanieVypusknikom|ru
ZapreshchenoRedaktirovanieVypusknikom|ZapreshchenoRedaktirovanieVypusknikom|en
publication_consent|publication_consent|ru
publication_consent|publication_consent|en
new_lastname|new_lastname|ru
new_lastname|Новая фамилия|en";
	}
}
