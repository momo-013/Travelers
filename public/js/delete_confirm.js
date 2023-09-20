 function deletePost(id){
    'use strict'
    
    if (confirm('削除すると復元できません。')){
        document.getElementById(`form_${id}`).submit();
    }
}