<!--
    available vars :
        filename
        thumbnail_url
        full_url
        file_id
-->
<table class="table" id="par_{{ $file_id }}" >
    <tr>
        <td rowspan="6">
            <img style="width:100px;" src="{{ $thumbnail_url }}"><br />
            <span class="file_copy" data-clipboard-text="{{ $full_url }}><i class="icon-copy"></i> copy URL</span>
        </td>
        <td><span class="img-title">{{ $filename }}</span></td>
        <td><span class="file_del" ><i class="file_del fa fa-trash-o" id="{{ $file_id }}"></i></span></td>
    </tr>
</table>
