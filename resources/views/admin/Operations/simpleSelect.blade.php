<script>
        var subcategory = {
            Mobile: ["Nokia", "Redmi", "Samsung"],
            Clothes: ["Shirt", "Pant", "T-shirt"]
        }

        function makeSubmenu(value) {
            if (value.length == 0) document.getElementById("categorySelect").innerHTML = "<option></option>";
            else {
                var citiesOptions = "";
                for (categoryId in subcategory[value]) {
                    citiesOptions += "<option>" + subcategory[value][categoryId] + "</option>";
                }
                document.getElementById("categorySelect").innerHTML = citiesOptions;
            }
        }
    </script>
</head>
<body>

<select id="category" size="1" onchange="makeSubmenu(this.value)">
<option value="" disabled selected>Choose Category</option>
<option>Mobile</option>
<option>Clothes</option>
</select>

<select id="categorySelect" size="1">
<option value="" disabled selected>Choose Subcategory</option>
<option></option>
</select>

</body>
