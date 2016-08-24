<?php

use common\models\Order;
use common\utils\ImageUtil;
use common\widgets\ImageDialog;
use common\widgets\StarsRating;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\widgets\FileAttachment;

$this->title = $order->name;

$this->registerJs(
	'$(window).bind("hashchange",  function(){'
		.'if (location.hash == null || location.hash == "" || location.hash == "#history"){'
			.'activateLink(0);'
			.'$.ajax({'
	  			.'method: "GET",'
	  			.'url: "'.Url::toRoute(['order/index']).'",'
	  			.'data: {"id": '.$order->id.'}'
			.'})'
	  			.'.done(function(order) {'
					.'if (order != ""){'
						.'drawHitory(order);'
					.'}'
	  			.'});'
		.'} else if (location.hash == "#edit"){'
			.'activateLink(0);'
			.'$.ajax({'
	  			.'method: "GET",'
	  			.'url: "'.Url::toRoute(['order/index']).'",'
	  			.'data: {"id": '.$order->id.'}'
			.'})'
	  			.'.done(function(order) {'
					.'if (order != ""){'
						.'drawEditCard(order);'
					.'}'
	  			.'});'
		.'} else if (location.hash.includes("#dialogs")){'
			.'activateLink(1);'
			.'var data = {};'
			.'$.ajax({'
	  			.'method: "GET",'
	  			.'url: "'.Url::toRoute(['order/dialogs']).'",'
	  			.'data: {"id": '.$order->id.'}'
			.'})'
	  			.'.done(function(dialogs) {'
					.'drawDialogs(dialogs);'
	  			.'});'
		.'} else if (location.hash.includes("#messages")){'
			.'activateLink(1);'
			.'var data = {};'
			.'var query = location.hash.split("?");'
			.'if (query.length==2){'
				.'data = getParams(query[1]);'
			.'}'
			.'data["id"] = '.$order->id.';'
			.'$.ajax({'
	  			.'method: "GET",'
	  			.'url: "'.Url::toRoute(['order/messages']).'",'
	  			.'data: data'
			.'})'
	  			.'.done(function(result) {'
					.'drawMessages(result);'
	  			.'});'
		.'} else if (location.hash == "#proposals"){'
			.'activateLink(2);'
			.''
		.'}'
	.'});'
	.'var links = $("div.sidebar > nav > ul > li");'
	.'links.each(function(index) {'
		.'$(this).click(function(){'
		.'});'
	.'});'
	.'var activateLink = function(num){'
		.'links.each(function(index){'
			.'if (num == index){'
				.'$(this).addClass("is-active");'
			.'} else {'
				.'$(this).removeClass("is-active");'
			.'}'
		.'});'
	.'};'
	.'var drawHitory = function(order){'
		.'var content = $("#tab-content");'
		.'content.empty();'
		.'content.append(drawCloseCard(order)+drawMainCard(order));'
		.'loadImages(order);'
		.'initImageDialog();'
		.'var images = content.find(".images-content a");'
		.'var statusDialog = content.find("#status_dialog");'
		.'if (!statusDialog[0].showModal) {'
			.'dialogPolyfill.registerDialog(statusDialog[0]);'
		.'}'
		.'statusDialog.find("#dialog_yes").click(function(){'
			.'statusDialog[0].close();'
			.'setOrderStatus(order["id"], '.Order::STATUS_CLOSED.');'
		.'});'
		.'statusDialog.find("#dialog_no").click(function(){'
			.'statusDialog[0].close();'
		.'});'
		.'content.find("#action_order").click(function(){'
			.'if (order["status"]=='.Order::STATUS_ACTIVE.'){'
				.'statusDialog[0].showModal();'
			.'} else {'
				.'setOrderStatus(order["id"], '.Order::STATUS_ACTIVE.');'
			.'}'
		.'});'
	.'};'
	.'var drawCloseCard = function (order){'
		.'if (order["status"]!='.Order::STATUS_CLOSED.') return "";'
		.'return "<div class=\"close-card mdl-card mdl-shadow--2dp\">'
					.'<div class=\"mdl-card__title\">'
    					.'<h2 class=\"mdl-card__title-text\">Заказ закрыт</h2>'
						.'<time class=\"mdl-color-text--grey-600\">"+order["closeDate"]+"</time>'
  					.'</div>'
					.'<div class=\"mdl-card__supporting-text\">'
			    		.'Если вы хотите открыть заказ, сделайте это ниже.'
					.'</div>'
				.'</div>";'
	.'};'
	.'var drawMainCard = function (order){'
		.'var range = "";'
		.'if (order["rangeMin"] != null) {'
			.'range = "от "+order["rangeMin"];'
		.'}'
		.'if (order["rangeMax"] != null) {'
			.'if (range != null) {'
				.'range += " ";'
			.'}'
			.'range += "до "+order["rangeMax"];'
		.'}'
		.'return "<div class=\"history-card mdl-card mdl-shadow--2dp\">'
  				.'<div class=\"mdl-card__title\">'
    				.'<h2 class=\"mdl-card__title-text\">Заказ создан</h2>'
					.'<time class=\"mdl-color-text--grey-600\">"+order["createDate"]+"</time>'
  				.'</div>'
				.'<div class=\"mdl-card__supporting-text\">'
				    .'Поздравляем! Ваш заказ активирован.'
				.'</div>'
				.'<div class=\"mdl-card__actions mdl-card--border\">'
					.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
						.'<div class=\"mdl-cell mdl-cell--3-col\">Название</div>'
						.'<div class=\"mdl-cell mdl-cell--9-col\"><h2 class=\"mdl-card__title-text\">"+order["name"]+"</h2></div>'
					.'</div>'
					.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
						.'<div class=\"mdl-cell mdl-cell--3-col\">Мастер</div>'
						.'<div class=\"master-content mdl-cell mdl-cell--9-col\">'
							.'<a class=\"avatar\" style=\"background-image: url(\''.ImageUtil::getUserAvatar($master->id).'\');\"></a>'
							.'<div class=\"details\">'
								.$master->lastName.' '.$master->firstName.'<br>'
								.$master->shop.' / '.$master->getPlace()->name.'<br>'
								.str_replace('"', '\"', StarsRating::widget([
										'rating' => 4,
										'reviews' => 10,
										'isSmall' => true,
								]))
							.'</div>'
						.'</div>'
					.'</div>'
					.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
						.'<div class=\"mdl-cell mdl-cell--3-col\">Размер</div>'
						.'<div class=\"mdl-cell mdl-cell--9-col\">"+(order["size"]==null?"Размер не указан":order["size"])+"</div>'
					.'</div>'
					.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
						.'<div class=\"mdl-cell mdl-cell--3-col\">Материалы</div>'
						.'<div class=\"mdl-cell mdl-cell--9-col\">"+(order["materials"]==null?"Материалы не указаны":order["materials"])+"</div>'
					.'</div>'
					.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
						.'<div class=\"mdl-cell mdl-cell--3-col\">Бюджет</div>'
						.'<div class=\"mdl-cell mdl-cell--9-col\">"+(range==""?"Бюджет не задан":range+" руб.")+"</div>'
					.'</div>'
					.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
						.'<div class=\"mdl-cell mdl-cell--3-col\">Описание</div>'
						.'<div class=\"mdl-cell mdl-cell--9-col\">"+order["details"]+"</div>'
					.'</div>'
					.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
						.'<div class=\"mdl-cell mdl-cell--3-col\">Изображения</div>'
						.'<div class=\"mdl-cell mdl-cell--9-col\">'
							.'<div class=\"images-content\"></div>'
						.'</div>'
					.'</div>'
				.'</div>'
				.'<div class=\"mdl-card__actions mdl-card--border\">'
					.'<a id=\"action_order\" class=\"mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect\">"'
						.'+(order["status"]=='.Order::STATUS_ACTIVE.'?"Закрыть":"Возобновить")+"'
				    .'</a>'
					.'<a id=\"edit_order\" class=\"mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect\" href=\"'.Url::toRoute(['', 'id' => $order->id, '#' => 'edit']).'\">'
						.'Изменить'
				    .'</a>'
				.'</div>'
			.'</div>'
			.str_replace('"', '\"', ImageDialog::widget(['skipInit' => true]))
			.'<dialog id=\"status_dialog\" class=\"confirm-dialog mdl-dialog\">'
				.'<div class=\"mdl-dialog__content\"><p>Вы действительно хотите закрыть заказ?</p></div>'
				.'<div class=\"mdl-dialog__action\">'
					.'<button id=\"dialog_yes\" type=\"button\" class=\"mdl-button\">Да</button>'
					.'<button id=\"dialog_no\" type=\"button\" class=\"mdl-button close\">Нет</button>'
				.'</div>'
			.'</dialog>'
			.'";'
	.'};'
	.'var loadImages = function(order){'
		.'$.ajax({'
  			.'method: "GET",'
  			.'url: "'.Url::toRoute(['file/uploads']).'",'
  			.'data: {projectId: order["projectId"], orderId: order["id"]}'
		.'})'
  			.'.done(function(images) {'
				.'var imagesContent = $(".images-content");'
				.'images.paths.forEach(function(image) {'
					.'$(document.createElement("a"))'
    					.'.attr({style: "background-image: url(\'"+image+"\');", "data-original": image})'
    					.'.appendTo(imagesContent)'
					    .'.click(function(){'
							.'showImageDialog($(this).attr("data-original"));'
					    .'});'
				.'});'
  			.'});'
	.'};'
	.'var setOrderStatus = function(id, status){'
		.'$.ajax({'
  			.'method: "GET",'
  			.'url: "'.Url::toRoute(['order/status']).'",'
  			.'data: {"id": id, "status": status}'
		.'})'
  			.'.done(function(order) {'
				.'if (order != ""){'
					.'$("#order_status").text(order["statusName"]);'
					.'drawHitory(order);'
				.'}'
  			.'});'
	.'};'
	.'var drawEditCard = function(order){'
		.'var content = $("#tab-content");'
		.'content.empty();'
		.'content.append("<div class=\"close-card mdl-card mdl-shadow--2dp\">'
							.'<div class=\"mdl-card__title\">'
		    					.'<h2 class=\"mdl-card__title-text\">Редактирование заказа</h2>'
		  					.'</div>'
							.'<div class=\"mdl-card__supporting-text\">'
					    		.'Вы можите отредактировать ваш заказ здесь, изменения будут отправлены Мастеру.'
							.'</div>'
							.'<form id=\"orderform\" action=\"'.Url::toRoute(['order/edit', 'id' => $order->id]).'\" method=\"post\" class=\"mdl-card__actions mdl-card--border\">'
								.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
									.'<div class=\"mdl-cell mdl-cell--3-col mdl-textfield__title\">Название</div>'
									.'<div class=\"mdl-cell mdl-cell--9-col mdl-textfield mdl-js-textfield\">'
										.'<input class=\"mdl-textfield__input\" type=\"text\" maxlength=\"255\" name=\"OrderForm[name]\" id=\"orderform-name\" value=\""+order["name"]+"\">'
										.'<label class=\"mdl-textfield__label\" for=\"orderform-name\">Краткое названия вашего проекта</label>'
										.'<span class=\"mdl-textfield__error\">Необходимо задать название</span>'
									.'</div>'
								.'</div>'
								.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
									.'<div class=\"mdl-cell mdl-cell--3-col mdl-textfield__title\">Укажите размер</div>'
									.'<div class=\"mdl-cell mdl-cell--9-col mdl-textfield mdl-js-textfield\">'
										.'<input class=\"mdl-textfield__input\" type=\"text\" maxlength=\"250\" name=\"OrderForm[size]\" id=\"orderform-size\" value=\""+(order["size"]==null?"":order["size"])+"\">'
									    .'<label class=\"mdl-textfield__label\" for=\"orderform-size\">Размер, единица измерения</label>'
									.'</div>'
								.'</div>'
								.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
									.'<div class=\"mdl-cell mdl-cell--3-col mdl-textfield__title\">Опишите материалы</div>'
									.'<div class=\"mdl-cell mdl-cell--9-col mdl-textfield mdl-js-textfield\">'
										.'<input class=\"mdl-textfield__input\" type=\"text\" maxlength=\"250\" name=\"OrderForm[materials]\" id=\"orderform-materials\" value=\""+(order["materials"]==null?"":order["materials"])+"\">'
									    .'<label class=\"mdl-textfield__label\" for=\"orderform-materials\">Дерево, платина, изумруды и т.д.</label>'
									.'</div>'
								.'</div>'
								.'<div class=\"range mdl-grid mdl-card__subtitle-text\">'
									.'<div class=\"mdl-cell mdl-cell--3-col mdl-textfield__title\">Укажите диапазон бюджета</div>'
									.'<div class=\"mdl-cell mdl-cell--9-col mdl-grid\">'
										.'<span class=\"mdl-textfield__title\">от </span>'
										.'<div class=\"mdl-cell mdl-textfield mdl-js-textfield\">'
									    	.'<input class=\"mdl-textfield__input\" type=\"text\" pattern=\"[0-9]*([\.,][0-9]+)?\" id=\"orderform-rangeMin\" name=\"OrderForm[rangeMin]\" value=\""+(order["rangeMin"]==null?"":order["rangeMin"])+"\">'
									    	.'<span class=\"mdl-textfield__error\">Неверный диапазон</span>'
									  	.'</div>'
										.'<span class=\" mdl-textfield__title\"> до </span>'
										.'<div class=\"mdl-cell mdl-textfield mdl-js-textfield\">'
									    	.'<input class=\"mdl-textfield__input\" type=\"text\" pattern=\"[0-9]*([\.,][0-9]+)?\" id=\"orderform-rangeMax\" name=\"OrderForm[rangeMax]\" value=\""+(order["rangeMax"]==null?"":order["rangeMax"])+"\">'
									    	.'<span class=\"mdl-textfield__error\">Неверный диапазон</span>'
									  	.'</div>'
										.'<span class=\" mdl-textfield__title\"> рублей<span>'
									.'</div>'
								.'</div>'
								.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
									.'<div class=\"mdl-cell mdl-cell--3-col mdl-textfield__title\">Описание</div>'
									.'<div class=\"mdl-cell mdl-cell--9-col mdl-textfield mdl-js-textfield\">'
										.'<textarea rows=\"5\" class=\"mdl-textfield__input\" type=\"text\" maxlength=\"250\" name=\"OrderForm[details]\" id=\"orderform-details\">"+(order["details"]==null?"":order["details"])+"</textarea>'
									    .'<label class=\"mdl-textfield__label\" for=\"orderform-details\">Задайте какие-либо вопросы, <br/>или расскажите о своем вдохновении</label>'
									.'</div>'
								.'</div>'
								.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
									.'<div class=\"mdl-cell mdl-cell--3-col\">Приложите фотографии или эскизы</div>'
									.'<div class=\"mdl-cell mdl-cell--9-col form-group field-orderform-customize has-success\">'
										.str_replace('"', '\"', FileAttachment::widget(['orderId' => $order->id, 'mainForm' => 'OrderForm']))
									.'</div>'
								.'</div>'
							.'</form>'
							.'<div class=\"mdl-card__actions mdl-card--border\">'
								.'<a id=\"action_edit\" class=\"mdl-button mdl-js-button mdl-button--raised mdl-button--colored\">'
									.'Сохранить'
							    .'</a>'
								.'<a id=\"action_cancel\" class=\"mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect\" href=\"'.Url::toRoute(['', 'id' => $order->id, '#' => 'history']).'\">'
									.'Отмена'
							    .'</a>'
							.'</div>'
						.'</div>");'
		.'componentHandler.upgradeElements($(".mdl-textfield").get());'
		.'getAllUploads();'
		.'var form = $("#orderform");'
		.'$("#action_edit").click(function(){'
			.'if (validateOrder(form)){'
				.'$.ajax({'
					.'type: form.attr("method"),'
					.'url: form.attr("action"),'
					.'data: form.serialize()'
				.'}).success(function(response) {'
					.'if (response != null && response != ""){'
						.'window.history.pushState("", "", "'.Url::toRoute(['', 'id' => $order->id, '#' => 'history']).'");'
						.'drawHitory(response);'
						.'showInfo("Изменения успешно сохранены");'
					.'}'
				.'}).error(function(){'
			        .'showInfo("При сохранении заказа произошла ошибка");'
			    .'});'
				.'return false;'
			.'}'
		.'});'
	.'};'
	.'var validateOrder = function(form){'
		.'var result = true;'
		.'var input;'
		.'var rangeMin = form.find("#orderform-rangeMin");'
		.'var rangeMax = form.find("#orderform-rangeMax");'
		.'var min = Number(rangeMin.val());'
		.'var max = Number(rangeMax.val());'
		.'if (isNaN(min)){'
			.'rangeMin.parent().addClass("is-invalid");'
			.'input = rangeMin;'
			.'result = false;'
		.'}'
		.'if (isNaN(max)){'
			.'rangeMax.parent().addClass("is-invalid");'
			.'input = rangeMax;'
			.'result = false;'
		.'}'
		.'if (result) {'
			.'if (min > max){'
				.'rangeMin.parent().addClass("is-invalid");'
				.'input = rangeMin;'
				.'result = false;'
			.'} else {'
				.'rangeMin.parent().removeClass("is-invalid");'
			.'}'
		.'}'
		.'var name = form.find("#orderform-name");'
		.'if (name.val() == null || name.val().trim() == ""){'
			.'name.parent().addClass("is-invalid");'
			.'input = name;'
			.'result = false;'
		.'} else {'
			.'name.parent().removeClass("is-invalid");'
		.'}'
		.'if (!result){'
			.'setTimeout(function(){'
			    .'input.focus();'
			.'}, 0);'
		.'}'
		.'return result;'
	.'};'
	.'var drawDialogs = function(dialogs){'
		.'var content = $("#tab-content");'
		.'content.empty();'
		.'var html = "<ul class=\"dialogs mdl-list mdl-shadow--2dp\">";'
		.'if (dialogs != ""){'
			.'dialogs.forEach(function(dialog) {'
				.'html += drawDialog(dialog);'
			.'})'
		.'};'
		.'html += "</ul>";'
		.'content.append(html);'
	.'};'
	.'var drawDialog = function(dialog){'
		.'return "<a href=\"#messages?'.(Yii::$app->user->identity->master?'userId="+dialog["userId"]+"':'masterId="+dialog["masterId"]+"').'\" class=\"mdl-list__item mdl-list__item--two-line\">'
					.'<div class=\"mdl-list__item-avatar\" style=\"background-image: url(\'"+dialog["avatar"]+"\');\"></div>'
    				.'<div class=\"mdl-list__item-primary-content\">'
						.'<time class=\"mdl-list__item-secondary-info\">"+(dialog["dateStr"]=="сегодня"?dialog["timeStr"]:dialog["dateStr"])+"</time>'
						.'<span>"+dialog["interlocutor"]+"</span>'
      					.'<span class=\"mdl-list__item-sub-title\">'
							.'"+(dialog["author"]=='.Yii::$app->user->getId().'?"Вы: ":"")+dialog["text"]+"'
      					.'</span>'
    				.'</div>'
  				.'</a>";'
	.'};'
	.'var drawMessages = function(result){'
		.'var interlocutor = result["interlocutor"];'
		.'var messages = result["messages"];'
		.'var content = $("#tab-content");'
		.'content.empty();'
		.'var html = "<div class=\"messages demo-card-wide mdl-card mdl-shadow--2dp\">'
						.'<div class=\"message-title mdl-card__title\">'
							.'<a href=\"#dialogs\" class=\"mdl-button mdl-js-button mdl-js-ripple-effect\">'
								.'<i class=\"material-icons\">keyboard_arrow_left</i>'
  								.'"+interlocutor["firstName"]+" "+interlocutor["lastName"]+"'
							.'</a>'
  						.'</div>";'
		.'html += "<div class=\"message-body mdl-card__actions\">'
					.'<ul class=\"messages mdl-list\">";'
		.'var date = null;'
		.'messages.forEach(function(message) {'
			.'if (date !== message["dateStr"]){'
				.'html += "<h5 class=\"message-date\"><span>"+message["dateStr"]+"</span></h5>";'
				.'date = message["dateStr"];'
			.'}'
			.'html += drawMessage(message, interlocutor);'
		.'});'
		.'html += "</ul></div>";'
		.'html += "<div class=\"message-form mdl-card__actions mdl-card--border\">'
					.'<form id=\"messageform\" action=\"'.Url::toRoute(['order/message', 'id' => $order->id]).'\" method=\"post\">'
						.'<div class=\"mdl-grid mdl-card__subtitle-text\">'
							.'<div class=\"mdl-cell mdl-cell--10-col mdl-textfield mdl-js-textfield\">'
								.'<textarea rows=\"2\" class=\"mdl-textfield__input\" type=\"text\" maxlength=\"250\" name=\"MessageForm[message]\" id=\"messageform-message\"></textarea>'
								.'<label class=\"mdl-textfield__label\" for=\"messageform-message\">Введите сообщение...</label>'
							.'</div>'
							.'<div class=\"mdl-cell mdl-cell--2-col mdl-textfield__title\">'
								.'<button id=\"action_send\" class=\"mdl-button mdl-js-button mdl-button--raised mdl-button--colored\">'
									.'Отправить'
								.'</button>'
							.'</div>'
						.'</div>'
					.'</form>'
				.'</div>";'
		.'html += "</div>";'
		.'content.append(html);'
		.'componentHandler.upgradeElements($(".mdl-textfield").get());'
		.'$(".message-body").scrollTop($(".message-body")[0].scrollHeight);'
		.'var form = $("#messageform");'
		.'$("#action_send").click(function(){'
			.'var message = form.find("#messageform-message").val();'
			.'if (message != null && message.trim() != ""){'
				.'$.ajax({'
					.'type: form.attr("method"),'
					.'url: form.attr("action"),'
					.'data: form.serialize()'
				.'}).success(function(response) {'
					.'console.log("message sended");'
					.'if (response != null && response != ""){'
						
					.'}'
				.'}).error(function(){'
					.'console.log("message error");'
			    .'});'
			.'}'
			.'return false;'
		.'});'
	.'};'
	.'var drawMessage = function(message, interlocutor){'
		.'var name;'
		.'if (message["author"] == '.Yii::$app->user->getId().'){'
			.'name = "'.Yii::$app->user->identity->firstName.'";'
		.'} else {'
			.'name = interlocutor["firstName"];'
		.'}'
		.'return "<div class=\"mdl-list__item mdl-list__item--many-line\">'
					.'<div class=\"mdl-list__item-avatar\" style=\"background-image: url(\'"+message["avatar"]+"\');\"></div>'
    				.'<div class=\"mdl-list__item-primary-content\">'
						.'<span>"+name+"</span>'
						.'<time class=\"mdl-list__item-secondary-info\">"+message["timeStr"]+"</time>'
      					.'<div class=\"mdl-list__item-sub-title\">'
							.'"+message["text"]+"'
      					.'</div>'
    				.'</div>'
  				.'</div>";'
	.'};'
	.'$(window).trigger("hashchange");', View::POS_READY);
?>
<div class="order-view mdl-grid">
	<div class="mdl-cell mdl-cell--3-col">
		<div class="sidebar">
			<header>
				<div class="inner">
					<h1><?php echo $order->name?></h1>
					<div id="master_name" class="master"><span>От:</span> <?php echo $master->lastName.' '.$master->firstName?></div>
					<div id="order_id" class="order">Заказ #<?php echo $order->id?></div>
					<div id="order_status" class="status"><?php echo $order->statusName?></div>
				</div>
			</header>
			<nav>
				<ul>
					<li class="is-active">
						<?php echo Html::a('История', ['', 'id' => $order->id, '#' => 'history'])?>
					</li>
					<li class="">
						<?php echo Html::a('Сообщения', ['', 'id' => $order->id, '#' => 'dialogs'])?>
					</li>
					<li class="">
						<?php echo Html::a('Предложения', ['', 'id' => $order->id, '#' => 'proposals'])?>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<div id="tab-content" class="mdl-cell mdl-cell--9-col"></div>
</div>