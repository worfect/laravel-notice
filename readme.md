Я тут просто сам с собой развлекаюсь. Если реально нужны уведомления, то тебе, наверное, сюда -  [laracasts/flash](https://github.com/laracasts/flash)

# Уведомления пользователя для вашего Laravel приложения

Пакет, использующий шаблоны Bootstrap, предоставлет широкие возможности для отправки пользователю уведомлений, большинством которых вы никогда не воспользуетесь.

## Установка

Добавьте в ваш файл composer.json:
```html
{
    repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/worfect/laravel-notice"
        }
    ],
    "require": {
        "worfect/laravel-notice": ":^1.0"
    }
}
```
Затем - Bootstrap стили, или самописные на их основе, в ваш HTML:
```html
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
```

На этом обязательная программа заканчивается, но, для полного раскрытия потенциала пакета, вам так же понадобится следующее:
```html
<!--Для использования important() и overlay() методов, вам понадобится jQuery -->
<script src="//code.jquery.com/jquery.js"></script>

<!-- А для эффекта исчезновения сообщения следующий скрипт -->
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
```

## Использование

Самый простой способ заключается с вызове функции  `notice()`  в вашем контроллере с передачей ей одного параметра - сообщения:
```php
public function example()
{
    notice('Hello World!');

    return view();
}
```
По умолчанию сообщение сохраняется со статусом `info` в сессию.

Установить статус можно вручную, передав его вторым параметром:
- `notice('Hi', 'success')`: уведомление об успехе;
- `notice('Hi', 'danger')`: уведомление об опасности;
- `notice('Hi', 'warning')`: уведомление-предупреждение;
- `notice('Hi', 'info')`: инфо-уведомление.
  
Для использования расширенного функционала необходимо использовать цепочку методов, которая должна оканчиваться одним из вариантов сохранения сообщения:
- `session()`: добаляет сообщение в сессию;
- `json()`: возвращает JSON строку, содержащую все сообщения, сохраненные как JSON во время обработки текущего запроса; 
- `html()`: возвращает HTML код, содержащий все сообщения, сохраненные как HTML во время обработки текущего запроса;
 
Установка статуса и текста сообщения осуществляется с помощью одного из соответствующих методов:
- `success('text')`;
- `danger('text')`; 
- `warning('text')`;
- `info('text')`.

Создание сообщения в модальном окне:
- `overlay('modal title optional')`.

Добавление кнопки закрытия всплывающего сообщения:
- `important()`.

`important()` и `overlay()` - взаимоисключающие методы. При попытке совместного использования сработает тот, что указан позже.

В расширенном формате можно использовать фасад `Notice::`вместо функции `notice()`.

Само собой возможно добавление нескольких сообщений. 

Пример:
```php
public function example()
{
    notice('text', 'success');
    \Worfect\Notice\Notice::danger('text')->session();
    notice()->success('text')->overlay('title')->session();
    notice()->info('text')->important()->json();
    notice()->danger('text')->html();
    
    return view();
}
```

Для отображения на странице сообщений переданных в сессию можете использовать предложенный шаблон:
```html
@include('flash::message')
```
Этот же шаблон будет использован для сохранения в HTML.
Для редактирования шаблона и просмотра примера обработки сообщений в формате JSON с помощью JQ:
```bash
php artisan vendor:publish --provider="Worfect\Notice\NoticeServiceProvider"
```
