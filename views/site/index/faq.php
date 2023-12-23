<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\web\View;

$testimonials = MgHelpers::getSettingOptionArray('faq '. Yii::$app->language);
if(count($testimonials) == 0){
    return false;
}

?>

<div class="section-faq py-5">
	<div class="container">
		<h2 class="section-title text-center">
			<?= Yii::t('db', 'FAQ'); ?>
        </h2>
		<div class="accordion accordion-faq" id="faq">
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    Co to jest ECM?
					</button>
				</h2>
				<div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faq">
                <div class="accordion-body">
					<p>
						ECM (Energy Coin Market) to sposób na budowę nowoczesnego ekologicznego systemu
energetycznego odzwierciedlonego w formie platformy internetowej. ECM to system, który umożliwi budowę
nowych jednostek wytwarzania ekologicznej energii, której posiadaczami będą sami uczestnicy ekosystemu.
ECM to również propozycja innej niż dotychczas formy- sposobu na użytkowanie energii.
                    </p>
                </div>
                </div>
            </div>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2"  aria-controls="collapse2">
                    Czym są OZE?
					</button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse " data-bs-parent="#faq">
                <div class="accordion-body">
                    <p>
                        OZE (odnawialne źródła energii) zgodnie z nazwa są to sposoby wytwarzania energii, które nie
zużywają zasobów naturalnych. Energia wytworzona jest tylko z takich źródeł, które w praktyce się nie kończą
(odnawiają) np. wiatr, słońce, energia geotermalna, energia pędu wody czy jej pływów.
                    </p>
                </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3"  aria-controls="collapse3">
                    Czym są systemy zeroemisyjne?
                </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse " data-bs-parent="#faq">
                <div class="accordion-body">
                    <p>
                        Systemy zeroemisyjne są to takie sposoby wytwarzania energii, przy których nie występuje emisja
zanieczyszczeń np. w postaci CO2.
                    </p>
                </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4"  aria-controls="collapse4">
                    Czym są klastry energii?
                </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse " data-bs-parent="#faq">
                <div class="accordion-body">
                    <p>
                        Klastry energii są ogólnoświatowym rozwiązaniem na rozproszenie systemu energetycznego. Klastry
jest to pewien wybrany obszar np. miasto, gmina, osiedle lub dowolnie określone miejsce, które ogranicza
produkcję i zużycie energii do swojego terytorium. Klaster charakteryzuje się uczestnikami, których dzielimy na
producentów , konsumentów energii, koordynatora, jednostki samorządowe, naukowe i inne.
                    </p>
                </div>
                </div>
            </div>

            </div>

            <div class="my-5 text-center">
                <a href="/faq/index?id=1" class="btn btn-primary btn-wide">Zobacz wszystkie</a>
            </div>

    </div>
</div>
