var Category = {

    category : $('.category'),
    dest : $('.product'),
    
    getCategory : function () {

        $.ajax({
            type: "GET",
            url: "/settings/categories/" + Category.category.val(),
            success: function (data) {
                var html;
                i = 0;
                for(i=0,l=data.length; i<l; i++){
                    html += "<option value="+ data[i].id +">"+ data[i].name +"</option>"
                }
                Category.dest.html(html);
            }
        });
    },
    
    init: function () {
        this.category.change(function () {
            Category.dest.html('');
            Category.getCategory();
        });
    }
}





