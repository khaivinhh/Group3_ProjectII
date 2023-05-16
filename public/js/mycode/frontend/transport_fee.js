const apiUrl_get_province = "https://online-gateway.ghn.vn/shiip/public-api/master-data/province";
const apiUrl_get_district = "https://online-gateway.ghn.vn/shiip/public-api/master-data/district";
const apiUrl_get_ward = "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward";
const apiUrl_get_shipping = "https: //online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee";

const token = "156086da-ee0e-11ed-a281-3aa62a37e0a5";
let selectElement_province = document.getElementById("province");
let selectElement_district = document.getElementById("district");
let selectElement_ward = document.getElementById("ward");
let input_address = document.getElementById("address");

fetch(apiUrl_get_province, {
    headers: {
        "Content-Type": "application/json",
        token: token,
    },
})
    .then((response) => response.json())
    .then((data) => {
        data.data.forEach((item) => {
            let optionElement = document.createElement("option");
            optionElement.value = item.ProvinceID;
            optionElement.textContent = item.ProvinceName;
            selectElement_province.appendChild(optionElement);
        });
    })
    .catch(error => console.log(error));




selectElement_province.addEventListener("change", function () {
    var id_province = this.value;
    selectElement_district.innerHTML = '';
    
    input_address.value = '';
    selectElement_ward.innerHTML = '';
    let optionElement = document.createElement("option");
    optionElement.value = '';
    optionElement.disabled = true;
    optionElement.selected = true;
    optionElement.hidden = true;
    optionElement.textContent = '';
    selectElement_district.appendChild(optionElement);
    fetch(apiUrl_get_district, {
        headers: {
            "Content-Type": "application/json",
            token: token,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            data.data.forEach((item) => {
                if (item.ProvinceID == id_province) {
                    let optionElement = document.createElement("option");
                    optionElement.value = item.DistrictID;
                    optionElement.textContent = item.DistrictName;
                    selectElement_district.appendChild(optionElement);
                }

            });
        })
        .catch(error => console.log(error));
});

selectElement_district.addEventListener("change", function () {
    var id_district = this.value;
    selectElement_ward.innerHTML = '';
    let optionElement = document.createElement("option");
    optionElement.value = '';
    optionElement.disabled = true;
    optionElement.selected = true;
    optionElement.hidden = true;
    optionElement.textContent = '';
    selectElement_ward.appendChild(optionElement);
    fetch(`${apiUrl_get_ward}?district_id=${id_district}`, {
        headers: {
            "Content-Type": "application/json",
            token: token,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            data.data.forEach((item) => {
                let optionElement = document.createElement("option");
                optionElement.value = item.WardCode;
                optionElement.textContent = item.WardName;
                selectElement_ward.appendChild(optionElement);
            });
        })
        .catch(error => console.log(error));
});



