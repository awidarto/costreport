var thumb = '<table class="table" id="par_'+ file.file_id +'" >' +
    '    <tr>' +
    '        <td rowspan="6"><img style="width:100px;" src="' + file.medium_url + '"><br />' +
    '            <span class="file_copy" data-clipboard-text="'+ file.url +'"><i class="icon-copy"></i> copy URL</span>' +
    '        </td>' +
    '        <td><span class="img-title">' + data.data.SKU + '</span></td>' +
    '        <td><span class="file_del" ></span><i class="file_del fa fa-trash-o" id="' + file.file_id +'"></i></td>' +
    '    </tr>' +
'</table>';