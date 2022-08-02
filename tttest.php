<?php
$tag_array = array("123", "I-86", "I-148");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


<input name='tags' value='' class="form-control" autofocus data-blacklist=''>



    <script>
    // tagify for tags suggestion
    var tag_array = json_encode($tag_array);
    var inputElm = document.querySelector('input[name=tags]'),
        whitelist = tag_array;
    var tagify = new Tagify(inputElm, {
        enforceWhitelist: true,
        whitelist: inputElm.value.trim().split(/\s*,\s*/)
    })
    tagify.on('add', onAddTag)
        .on('remove', onRemoveTag)
        .on('input', onInput)
        .on('edit', onTagEdit)
        .on('invalid', onInvalidTag)
        .on('click', onTagClick)
        .on('focus', onTagifyFocusBlur)
        .on('blur', onTagifyFocusBlur)
        .on('dropdown:hide dropdown:show', e => console.log(e.type))
        .on('dropdown:select', onDropdownSelect)
    var mockAjax = (function mockAjax() {
        var timeout;
        return function(duration) {
            clearTimeout(timeout);
            return new Promise(function(resolve, reject) {
                timeout = setTimeout(resolve, duration || 700, whitelist)
            })
        }
    })()

    function onAddTag(e) {
        console.log("onAddTag: ", e.detail);
        console.log("original input value: ", inputElm.value)
        tagify.off('add', onAddTag) // exmaple of removing a custom Tagify event
    }

    function onRemoveTag(e) {
        console.log("onRemoveTag:", e.detail, "tagify instance value:", tagify.value)
    }

    function onInput(e) {
        console.log("onInput: ", e.detail);
        tagify.settings.whitelist.length = 0;
        tagify.loading(true).dropdown.hide.call(tagify)
        mockAjax()
            .then(function(result) {
                tagify.settings.whitelist.push(...result, ...tagify.value)
                tagify.loading(false).dropdown.show.call(tagify, e.detail.value);
            })
    }

    function onTagEdit(e) {
        console.log("onTagEdit: ", e.detail);
    }

    function onInvalidTag(e) {
        console.log("onInvalidTag: ", e.detail);
    }

    function onTagClick(e) {
        console.log(e.detail);
        console.log("onTagClick: ", e.detail);
    }

    function onTagifyFocusBlur(e) {
        console.log(e.type, "event fired")
    }

    function onDropdownSelect(e) {
        console.log("onDropdownSelect: ", e.detail)
    }
    </script>

</body>

</html>