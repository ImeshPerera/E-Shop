function AlertDanger(msg) {
    if (msg == null) {
        msg = "Something Went Wrong. Report To Admin";
    }
    document.getElementById("alertnobtn").classList.add("d-none");
    document.getElementById("alertnobox").classList.remove("d-none");
    document.getElementById("alertnoline").innerText = msg;
}

function AlertSuccess(msg) {
    if (msg == null) {
        msg = "Something Happend. Report To Admin";
    }
    document.getElementById("alertokbtn").classList.add("d-none");
    document.getElementById("alertokbox").classList.remove("d-none");
    document.getElementById("alertokline").innerText = msg;
}

function alertDangerclose() {
    var alertnobox = document.getElementById("alertnobox");
    alertnobox.classList.add("d-none");
}

function alertSuccessclose() {
    var alertokbox = document.getElementById("alertokbox");
    alertokbox.classList.add("d-none");
}

function ApplyAlertBtn(btnid, where, line, color) {
    var alertbtn = document.getElementById(btnid);
    alertbtn.classList.remove("d-none");
    alertbtn.classList.add(color);
    alertbtn.setAttribute('href', where);
    alertbtn.innerHTML = line;
}

function changeView() {
    var signInBox = document.getElementById("signInBox");
    var signUpBox = document.getElementById("signUpBox");

    signInBox.classList.toggle("d-none");
    signUpBox.classList.toggle("d-none");
}

function SignUp() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var mobile = document.getElementById("mobile");
    var gender = document.getElementById("gender");

    var SignUpForm = new FormData();
    SignUpForm.append("fname", fname.value);
    SignUpForm.append("lname", lname.value);
    SignUpForm.append("email", email.value);
    SignUpForm.append("password", password.value);
    SignUpForm.append("mobile", mobile.value);
    SignUpForm.append("gender", gender.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text1 = r.responseText;
            if (text1 == "Success") {
                fname.value = "";
                lname.value = "";
                email.value = "";
                mobile.value = "";
                password.value = "";
                AlertSuccess('Sign Up Process is Success');
                alertDangerclose();
                changeView();
            } else {
                AlertDanger(text1);
            }
        }
    };

    r.open("POST", "process/process1.php", true);
    r.send(SignUpForm);
}

function SignIn() {
    var email2 = document.getElementById("email2");
    var password2 = document.getElementById("password2");
    var remember = document.getElementById("remember");

    var form = new FormData();
    form.append("email", email2.value);
    form.append("password", password2.value);
    form.append("remember", remember.checked);

    var s = new XMLHttpRequest();

    s.onreadystatechange = function() {
        if (s.readyState == 4) {
            var text2 = s.responseText;
            if (text2 == "Success") {
                alertDangerclose();
                window.location = "home.php";
            } else {
                AlertDanger(text2);
            }
        }
    };

    s.open("POST", "process/process2.php", true);
    s.send(form);
}

var modelshow;
var email4;

function ForgotPassword() {
    var email3 = document.getElementById("email2");
    email4 = email3;
    var t = new XMLHttpRequest();
    swal({ title: "Wait for Status", });
    t.onreadystatechange = function() {
        if (t.readyState == 4) {
            var text3 = t.responseText;
            if (text3 == "Please enter your email address") {
                swal({ title: text3, });
            }
            if (text3 == "Message has been sent.") {
                swal({ title: text3, });
                modelshow = new bootstrap.Modal(document.getElementById('forgetPasswordModel'), { backdrop: 'static', keyboard: false });
                modelshow.show();
            } else {
                swal({ title: text3, });
            }
        }
    };

    t.open("GET", "process/process3.php?e=" + email3.value, true);
    t.send();
}

function ResetPassword() {
    var password3 = document.getElementById("password3");
    var password4 = document.getElementById("password4");
    var varifycode = document.getElementById("verifycode");

    var formre = new FormData;
    formre.append("email4", email4.value);
    formre.append("pass1", password3.value);
    formre.append("pass2", password4.value);
    formre.append("vcode", varifycode.value);

    var s = new XMLHttpRequest();

    s.onreadystatechange = function() {
        if (s.readyState == 4) {
            var text4 = s.responseText;
            if (text4 == "Success") {
                swal({ icon: "success", text: "Password Reset is Success", });
                modelshow.hide();
            } else {
                swal({ text: text4, });
            }
        }
    };

    s.open("POST", "process/process4.php", true);
    s.send(formre);
}

function showPass1() {
    var password1 = document.getElementById("password");
    var password1b = document.getElementById("password1b");
    password1b.classList.toggle("bi-eye");
    password1b.classList.toggle("bi-eye-slash");
    if (password1.type == "password") {
        password1.type = "text";
    } else {
        password1.type = "password";
    }
}

function showPass2() {
    var password2 = document.getElementById("password2");
    var password2b = document.getElementById("password2b");
    password2b.classList.toggle("bi-eye");
    password2b.classList.toggle("bi-eye-slash");
    if (password2.type == "password") {
        password2.type = "text";
    } else {
        password2.type = "password";
    }
}

function showPass3() {
    var password3 = document.getElementById("password3");
    var password3b = document.getElementById("password3b");
    password3b.classList.toggle("bi-eye");
    password3b.classList.toggle("bi-eye-slash");
    if (password3.type == "password") {
        password3.type = "text";
    } else {
        password3.type = "password";
    }
}

function showPass4() {
    var password4 = document.getElementById("password4");
    var password4b = document.getElementById("password4b");
    password4b.classList.toggle("bi-eye");
    password4b.classList.toggle("bi-eye-slash");
    if (password4.type == "password") {
        password4.type = "text";
    } else {
        password4.type = "password";
    }
}

function showcatagory(z) {
    var ListingCatagory = document.getElementById(z);
    var SelectCat = document.getElementById("dropdownMenuButton1");
    SelectCat.innerHTML = ListingCatagory.innerHTML;
    SelectCat.value = ListingCatagory.value;
    LoadBrandsList();
}

function showbrand(z) {
    var ListingBrand = document.getElementById(z);
    var SelectBrd = document.getElementById("dropdownMenuButton2");
    SelectBrd.innerHTML = ListingBrand.innerHTML;
    SelectBrd.value = ListingBrand.value;
    LoadModelsList();
}

function showmodel(z) {
    var ListingModel = document.getElementById(z);
    var SelectMod = document.getElementById("dropdownMenuButton3");
    SelectMod.innerHTML = ListingModel.innerHTML;
    SelectMod.value = ListingModel.value;
}

function gotoAddProduct() {
    window.location = "addproduct.php";
}

function ChangeImage() {
    var TheImage = document.getElementById("imguploaded");
    var ViewImag = document.getElementById("PrevImag");
    TheImage.onchange = function() {
        var ImageFile = this.files[0];
        var Url = window.URL.createObjectURL(ImageFile);
        ViewImag.src = Url;
        var imgBox2 = document.getElementById("imgBox2");
        imgBox2.classList.remove('d-none');
    }
}

function ChangeImage2() {
    var TheImage = document.getElementById("imguploaded2");
    var ViewImag = document.getElementById("PrevImag2");
    TheImage.onchange = function() {
        var ImageFile = this.files[0];
        var Url = window.URL.createObjectURL(ImageFile);
        ViewImag.src = Url;
        var imgBox3 = document.getElementById("imgBox3");
        imgBox3.classList.remove('d-none');
    }
}

function ChangeImage3() {
    var TheImage = document.getElementById("imguploaded3");
    var ViewImag = document.getElementById("PrevImag3");

    TheImage.onchange = function() {
        var ImageFile = this.files[0];
        var Url = window.URL.createObjectURL(ImageFile);
        ViewImag.src = Url;
    }
}

function ChangeImageRe(topp, bott) {
    var ThereImage = document.getElementById(topp);
    var ViewreImag = document.getElementById(bott);

    ThereImage.onchange = function() {
        var reImageFile = this.files[0];
        var URl = window.URL.createObjectURL(reImageFile);
        ViewreImag.src = URl;
        alert(reImageFile + URl);
    }
}

function changeProductView() {
    var Listing = document.getElementById("addProductBox");
    var Updating = document.getElementById("updateProductBox");
    Listing.classList.toggle("d-none");
    Updating.classList.toggle("d-none");
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function LoadBrandsList() {
    var SelectCat = document.getElementById("dropdownMenuButton1");
    var SelectBrd = document.getElementById("dropdownMenuButton2");
    var BrdFillUp = document.getElementById("BrdFillUp");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text21 = r.responseText;
            if (text21 == 100) {
                SelectBrd.innerHTML = "All Brands";
                SelectBrd.value = 0;
                BrdFillUp.innerHTML = "<li><button class='dropdown-item point-none'>Error With Catagory</button></li>";
            } else {
                BrdFillUp.innerHTML = text21;
            }
        }
    }
    r.open("POST", "process/process21.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("CatId=" + SelectCat.value);

}

function LoadModelsList() {
    var SelectBrd = document.getElementById("dropdownMenuButton2");
    var SelectMod = document.getElementById("dropdownMenuButton3");
    var ModFillUp = document.getElementById("ModFillUp");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text22 = r.responseText;
            if (text22 == 100) {
                SelectMod.innerHTML = "All Models";
                SelectMod.value = 0;
                ModFillUp.innerHTML = "<li><button class='dropdown-item point-none'>Error With Brand</button></li>";
            } else {
                ModFillUp.innerHTML = text22;
            }
        }
    }
    r.open("POST", "process/process22.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("BrdId=" + SelectBrd.value);

}

function ListingProduct() {
    var ConditionId;
    var ProductColorId;
    var Catagoryid = document.getElementById("dropdownMenuButton1");
    var Brandid = document.getElementById("dropdownMenuButton2");
    var Modelid = document.getElementById("dropdownMenuButton3");
    var ListingTitle = document.getElementById("ListingTitle");
    for (var CondStart = 1; CondStart < 3; CondStart++) {
        if (document.getElementById("ConditionRadio" + CondStart).checked) {
            var ConditionId = document.getElementById("ConditionRadio" + CondStart).value;
        }
    }
    var ColorBoxes = document.getElementById("ColorBoxes").value;
    for (var Begin = 1; Begin < ColorBoxes; Begin++) {
        if (document.getElementById("Colorbox" + Begin).checked) {
            var ProductColorId = document.getElementById("Colorbox" + Begin).value;
        }
    }
    var ListingQty = document.getElementById("ListingQty");
    var ListingPrice = document.getElementById("ListingPrice");
    var ListingDeliveryIn = document.getElementById("ListingDeliveryIn");
    var ListingDeliveryOut = document.getElementById("ListingDeliveryOut");
    var ListingDescription = document.getElementById("ListingDescription");
    var ProductImag = document.getElementById("imguploaded");
    var ProductImag2 = document.getElementById("imguploaded2");
    var ProductImag3 = document.getElementById("imguploaded3");

    var formListing = new FormData;

    formListing.append("Catagoryid", Catagoryid.value);
    formListing.append("Brandid", Brandid.value);
    formListing.append("Modelid", Modelid.value);
    formListing.append("ListingTitle", ListingTitle.value);
    formListing.append("ConditionId", ConditionId);
    formListing.append("ProductColorId", ProductColorId);
    formListing.append("ListingQty", ListingQty.value);
    formListing.append("ListingPrice", ListingPrice.value);
    formListing.append("ListingDeliveryIn", ListingDeliveryIn.value);
    formListing.append("ListingDeliveryOut", ListingDeliveryOut.value);
    formListing.append("ListingDescription", ListingDescription.value);
    formListing.append("TheImage", ProductImag.files[0]);
    formListing.append("TheImage2", ProductImag2.files[0]);
    formListing.append("TheImage3", ProductImag3.files[0]);

    var Li = new XMLHttpRequest();

    Li.onreadystatechange = function() {
        if (Li.readyState == 4) {
            var text5 = Li.responseText;
            if (text5 == "SA1") {
                AlertSuccess('Product Listed Successfully.');
                alertDangerclose();
                ApplyAlertBtn('alertokbtn', 'sellproductview.php', 'View Product Page', 'btn-success');
            } else {
                AlertDanger(text5);
            }
        }
    };

    Li.open("POST", "process/process5.php", true);
    Li.send(formListing);
}

function SignOut() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text6 = r.responseText;
            if (text6 == "Success") {
                window.location = "home.php";
            } else {}
        }
    }
    r.open("GET", "process/process6.php", true);
    r.send();
}

function showProvince(z) {
    var Provin = document.getElementById(z);
    var SelectPro = document.getElementById("dropdownMenuButton4");
    SelectPro.innerHTML = Provin.innerHTML;
    SelectPro.value = Provin.value;

    var Ddropmenu = document.getElementById("districtdropmenu");

    var p = new XMLHttpRequest();
    p.onreadystatechange = function() {
        if (p.readyState == 4) {
            var text7 = p.responseText;
            Ddropmenu.innerHTML = text7;
        }
    }
    p.open("POST", "process/process7.php", true);
    p.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    p.send("provinceid=" + Provin.value);
}

function ChangeUserImage() {
    var TheUserImage = document.getElementById("Userprofileimg");
    var ViewUserImag = document.getElementById("UserImage");

    TheUserImage.onchange = function() {
        var UserImageFile = this.files[0];
        var UserUrl = window.URL.createObjectURL(UserImageFile);
        ViewUserImag.src = UserUrl;

        var imageform = new FormData;
        imageform.append("UserImage", TheUserImage.files[0]);

        var q = new XMLHttpRequest();
        q.onreadystatechange = function() {
            if (q.readyState == 4) {
                var text8 = q.responseText;
                if (text8 == "SA1") {
                    AlertSuccess('Profile Image Successfully Updated.');
                    alertDangerclose();
                } else {
                    AlertDanger(text8);
                }
            }
        }
        q.open("POST", "process/process8.php", true);
        q.send(imageform);
    }
}

function resetDist() {
    var SelectDis = document.getElementById("dropdownMenuButton5");
    SelectDis.innerHTML = "Select District";
    SelectDis.value = "0";
}

function showDistrict(z) {
    var Distric = document.getElementById(z);
    var SelectDis = document.getElementById("dropdownMenuButton5");
    SelectDis.innerHTML = Distric.innerHTML;
    SelectDis.value = Distric.value;
}

function showUpPass() {
    var UserUppassword = document.getElementById("UserUppassword");
    var UserUppasswordb = document.getElementById("UserUppasswordb");
    UserUppasswordb.classList.toggle("bi-eye");
    UserUppasswordb.classList.toggle("bi-eye-slash");
    if (UserUppassword.type == "password") {
        UserUppassword.type = "text";
    } else {
        UserUppassword.type = "password";
    }
}

function UpdateUserProfile() {
    var UserUpfname = document.getElementById("UserUpfname").value;
    var UserUplname = document.getElementById("UserUplname").value;
    var UserUpmobile = document.getElementById("UserUpmobile").value;
    var UserUppassword = document.getElementById("UserUppassword").value;
    var UserUpemail = document.getElementById("UserUpemail").value;
    var UserUpline1 = document.getElementById("UserUpline1").value;
    var UserUpline2 = document.getElementById("UserUpline2").value;
    var UserUpProvinceid = document.getElementById("dropdownMenuButton4").value;
    var UserUpDistrictid = document.getElementById("dropdownMenuButton5").value;
    var UserUpcity = document.getElementById("UserUpcity").value;
    var UserUppostal = document.getElementById("UserUppostal").value;

    var Updateform = new FormData;

    Updateform.append("UserUpfname", UserUpfname);
    Updateform.append("UserUplname", UserUplname);
    Updateform.append("UserUpmobile", UserUpmobile);
    Updateform.append("UserUppassword", UserUppassword);
    Updateform.append("UserUpemail", UserUpemail);
    Updateform.append("UserUpline1", UserUpline1);
    Updateform.append("UserUpline2", UserUpline2);
    Updateform.append("UserUpProvinceid", UserUpProvinceid);
    Updateform.append("UserUpDistrictid", UserUpDistrictid);
    Updateform.append("UserUpcity", UserUpcity);
    Updateform.append("UserUppostal", UserUppostal);

    var u = new XMLHttpRequest();
    u.onreadystatechange = function() {
        if (u.readyState == 4) {
            var text9 = u.responseText;
            if (text9 == "SA1") {
                AlertSuccess('Details Updated Successfully.');
                alertDangerclose();
            } else {
                if (text9 == "SA2") {
                    AlertSuccess('Details Added Successfully.');
                    alertDangerclose();
                } else {
                    AlertDanger(text9);
                }
            }
        }
    }
    u.open("POST", "process/process9.php", true);
    u.send(Updateform);

}

function IndexAlert(tx) {
    AlertDanger('Sign In to Proceed Your Request');
}

function ChangeStatus(cs) {
    var ChangeMe = document.getElementById(cs);
    var StatusShow = document.getElementById("StsNow" + ChangeMe.value);
    var ChangeMeto;
    if (ChangeMe.checked) {
        ChangeMeto = 2;
    } else {
        ChangeMeto = 1;
    }
    var q = new XMLHttpRequest();
    q.onreadystatechange = function() {
        if (q.readyState == 4) {
            var text10 = q.responseText;
            if (text10 == "SUD") {
                AlertSuccess('Product Disabled Successfully.');
                StatusShow.classList.remove("text-green");
                StatusShow.classList.add("text-danger");
                StatusShow.innerHTML = "Disabaled";
                alertDangerclose();
            } else if (text10 == "SUL") {
                AlertSuccess('Product Listed Successfully');
                StatusShow.classList.remove("text-danger");
                StatusShow.classList.add("text-green");
                StatusShow.innerHTML = "In Stock";
                alertDangerclose();
            } else {
                AlertDanger(text10);
                ChangeMe.checked = true;
            }
        }
    }
    q.open("POST", "process/process10.php", true);
    q.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    q.send("ChangeProduct=" + ChangeMe.value + "&ChangeMeto=" + ChangeMeto);
}

function SearchtoUpdate() {
    var UpdateSearch = document.getElementById("UpdateProductSearch");
    var UpdateFill = document.getElementById("UpdateProductsFill");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text11 = r.responseText;
            UpdateFill.innerHTML = text11;
        }
    }
    r.open("POST", "process/process11.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("UpdateSearch=" + UpdateSearch.value);
}

function UpdateThisItem(ui) {
    var UpdateItem = document.getElementById(ui);
    var UpdateProductId = UpdateItem.value;
    var UpdateSearch = document.getElementById("UpdateProductSearch");
    UpdateSearch.value = UpdateItem.innerHTML;
    var UpdateArea = document.getElementById("UpdateArea");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text12 = r.responseText;
            UpdateArea.innerHTML = text12;
        }
    }
    r.open("POST", "process/process12.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("UpdateProductId=" + UpdateProductId);
}

function UpdateThisItemEx(ui) {
    var UpdateProductId = ui;
    var UpdateArea = document.getElementById("UpdateArea");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text12 = r.responseText;
            UpdateArea.innerHTML = text12;
        }
    }
    r.open("POST", "process/process12.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("UpdateProductId=" + UpdateProductId);
}

function UpdateSearchClear() {
    window.location = "addproduct.php?Update";
}

function UpdateSellerProduct() {
    var UpdateProductId = document.getElementById("UpdateProductId");
    var UpdatingTitle = document.getElementById("UpdatingTitle");
    var UpdatingQty = document.getElementById("UpdatingQty");
    var UpdatingDeliveryIn = document.getElementById("UpdatingDeliveryIn");
    var UpdatingDeliveryOut = document.getElementById("UpdatingDeliveryOut");
    var UpdatingDescription = document.getElementById("UpdatingDescription");
    var imgreuploaded1 = document.getElementById("imgreuploaded1");
    var imgreuploaded2 = document.getElementById("imgreuploaded2");
    var imgreuploaded3 = document.getElementById("imgreuploaded3");

    var UpdateProductform = new FormData;

    UpdateProductform.append("UpdateProductId", UpdateProductId.value);
    UpdateProductform.append("UpdatingTitle", UpdatingTitle.value);
    UpdateProductform.append("UpdatingQty", UpdatingQty.value);
    UpdateProductform.append("UpdatingDeliveryIn", UpdatingDeliveryIn.value);
    UpdateProductform.append("UpdatingDeliveryOut", UpdatingDeliveryOut.value);
    UpdateProductform.append("UpdatingDescription", UpdatingDescription.value);
    UpdateProductform.append("imgreuploaded1", imgreuploaded1.files[0]);
    UpdateProductform.append("imgreuploaded2", imgreuploaded2.files[0]);
    UpdateProductform.append("imgreuploaded3", imgreuploaded3.files[0]);

    var q = new XMLHttpRequest();
    q.onreadystatechange = function() {
        if (q.readyState == 4) {
            var text13 = q.responseText;
            if (text13 == "SA1") {
                AlertSuccess('Product Listed Successfully.');
                alertDangerclose();
                ApplyAlertBtn('alertokbtn', 'sellproductview.php', 'View Product', 'btn-success');
            } else {
                AlertDanger(text13);
            }

        }
    }
    q.open("POST", "process/process13.php", true);
    q.send(UpdateProductform);

}

function SellerSearch(pg) {
    var SellerSearchInput = document.getElementById("SellerSearchInput").value;
    var SearchProductFill = document.getElementById("SearchProductFill");
    var ProNeOl = document.getElementById("ProNeOl");
    var ProOlNe = document.getElementById("ProOlNe");
    var QtyLoHi = document.getElementById("QtyLoHi");
    var QtyHiLo = document.getElementById("QtyHiLo");
    var CondNew = document.getElementById("CondNew");
    var CondUse = document.getElementById("CondUse");
    var Active = 0;
    var Quantity = 0;
    var Condition = 0;
    if (pg == null) {
        pg = 1;
    }
    if (ProNeOl.checked) {
        Active = 1;
    }
    if (ProOlNe.checked) {
        Active = 2;
    }
    if (QtyLoHi.checked) {
        Quantity = 1;
    }
    if (QtyHiLo.checked) {
        Quantity = 2;
    }
    if (CondNew.checked) {
        Condition = 1;
    }
    if (CondUse.checked) {
        Condition = 2;
    }
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text14 = r.responseText;
            SearchProductFill.innerHTML = text14;
        }
    }
    r.open("POST", "process/process14.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("SellerSearchInput=" + SellerSearchInput + "&pg=" + pg + "&Active=" + Active + "&Quantity=" + Quantity + "&Condition=" + Condition);

}

function ResetSorting() {
    document.getElementById("SellerSearchInput").value = null;
    document.getElementById("ProNeOl").checked = false;
    document.getElementById("ProOlNe").checked = false;
    document.getElementById("QtyLoHi").checked = false;
    document.getElementById("QtyHiLo").checked = false;
    document.getElementById("CondNew").checked = false;
    document.getElementById("CondUse").checked = false;
}

function QtyPlus() {
    var a = 1;
    var b = 1;
    var num = document.getElementById("QtyNum"),
        QtyNum = document.getElementById("QtyMax");
    a = parseInt(num.value, 10);
    b = parseInt(QtyNum.innerText, 10);
    if (a < b) {
        a++;
        a = (a < 10) ? "0" + a : a;
        num.value = a;
    } else if (a >= b) {
        b = (b < 10) ? "0" + b : b;
        num.value = b;
    } else {
        num.value = b;
    }
}

function QtyMinus() {
    var a = 1;
    var b = 1;
    var num = document.getElementById("QtyNum"),
        QtyNum = document.getElementById("QtyMax");
    a = parseInt(num.value, 10);
    b = parseInt(QtyNum.innerText, 10);
    if (a > b) {
        b = (b < 10) ? "0" + b : b;
        num.value = b;
    } else if (a > 0) {
        a--;
        a = (a < 10) ? "0" + a : a;
        num.value = a;
    } else if (a < 0) {
        num.value = 01;
    } else if (a == 0) {
        num.value = '00';
    } else if (a == b) {
        num.value = '01';
    } else {
        num.value = '00';
    }

}

function CheckBuyQty() {
    var a = 1;
    var b = 1;
    var num = document.getElementById("QtyNum"),
        QtyNum = document.getElementById("QtyMax");
    a = parseInt(num.value, 10);
    b = parseInt(QtyNum.innerText, 10);
    if (a < b && a != 0) {
        a = (a < 10) ? "0" + a : a;
        num.value = a;
    } else if (a > b) {
        b = (b < 10) ? "0" + b : b;
        num.value = b;
    } else if (b == 0) {
        num.value = '00';
    } else if (a == 0) {
        num.value = '01';
    } else {
        num.value = '01';
    }
}

function AdScatagory(z) {
    var AdsCatagory = document.getElementById(z);
    var SAdCat = document.getElementById("dropdownMenuButton6");
    SAdCat.innerHTML = AdsCatagory.innerHTML;
    SAdCat.value = AdsCatagory.value;
}

function AdSbrand(z) {
    var AdsBrand = document.getElementById(z);
    var SAdBrd = document.getElementById("dropdownMenuButton7");
    SAdBrd.innerHTML = AdsBrand.innerHTML;
    SAdBrd.value = AdsBrand.value;
}

function AdSmodel(z) {
    var AdsModel = document.getElementById(z);
    var SAdMod = document.getElementById("dropdownMenuButton8");
    SAdMod.innerHTML = AdsModel.innerHTML;
    SAdMod.value = AdsModel.value;
}

function AdScondition(z) {
    var AdsCond = document.getElementById(z);
    var SAdCond = document.getElementById("dropdownMenuButton9");
    SAdCond.innerHTML = AdsCond.innerHTML;
    SAdCond.value = AdsCond.value;
}

function AdSColor(z) {
    var AdsColr = document.getElementById(z);
    var SAdColr = document.getElementById("dropdownMenuButton10");
    SAdColr.innerHTML = AdsColr.innerHTML;
    SAdColr.value = AdsColr.value;
}

function AdvanceSearch(pg) {
    var AdvanceSearchFill = document.getElementById("AdvanceSearchFill");
    var AdSearch = document.getElementById("AdSearch");
    var AdCat = document.getElementById("dropdownMenuButton6");
    var AdBrd = document.getElementById("dropdownMenuButton7");
    var AdMod = document.getElementById("dropdownMenuButton8");
    var AdCon = document.getElementById("dropdownMenuButton9");
    var AdClr = document.getElementById("dropdownMenuButton10");
    var AdPfr = document.getElementById("AdPriceFrom");
    var AdPto = document.getElementById("AdPriceTo");
    if (pg == null) {
        pg = 1;
    }

    var AdvanceFrom = new FormData();

    AdvanceFrom.append("AdSearch", AdSearch.value);
    AdvanceFrom.append("AdCat", AdCat.value);
    AdvanceFrom.append("AdBrd", AdBrd.value);
    AdvanceFrom.append("AdMod", AdMod.value);
    AdvanceFrom.append("AdCon", AdCon.value);
    AdvanceFrom.append("AdClr", AdClr.value);
    AdvanceFrom.append("AdPfr", AdPfr.value);
    AdvanceFrom.append("AdPto", AdPto.value);
    AdvanceFrom.append("page", pg)

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text15 = r.responseText;
            AdvanceSearchFill.innerHTML = text15;
        }
    }
    r.open("POST", "process/process15.php", true);
    r.send(AdvanceFrom);

}

function AddWishList(id) {
    var WishHeart = document.getElementById("HeartWish" + id);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text16 = r.responseText;
            if (text16 == "SA1") {
                WishHeart.classList.add("text-warning");
            } else if (text16 == "DE1") {
                WishHeart.classList.remove("text-warning");
            } else if (text16 == "ER1") {
                AlertDanger('Sign in to add this product to the WishList.');
                ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');
            } else {
                AlertDanger(text16);
            }
        }
    }
    r.open("POST", "process/process16.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("ProductId=" + id);

}

function MoveToRecent(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text17 = r.responseText;
            SearchInWatchlist();
            if (text17 == "ER1") {
                AlertDanger('Sign in to remove this product from the WishList.');
                ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');
            }
        }
    }
    r.open("POST", "process/process17.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("ProductId=" + id);
}

function AddToCart(id, qt) {
    if (qt == null) {
        qt = document.getElementById("QtyNum").value;
    }
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text18 = r.responseText;
            if (text18 == "SA1") {
                AlertSuccess('Adding products to the cart is successful.');
                alertDangerclose();
                ApplyAlertBtn('alertokbtn', 'cart.php', 'Cart Page', 'btn-success');
            } else if (text18 == "ER1") {
                AlertDanger('Sign in to add this product to the cart.');
                ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');
            } else {
                AlertDanger(text18);
            }
        }
    }
    r.open("POST", "process/process18.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("ProductId=" + id + "&BuyQty=" + qt);
}

function AddCartPage(id) {
    var qt = document.getElementById("QtyCartNum" + id).value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text18 = r.responseText;
            if (text18 == "SA1") {
                CartCheckout();
            } else if (text18 == "ER1") {
                AlertDanger('Sign in to add this product to the cart.');
                ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');
            } else {
                AlertDanger(text18);
            }
        }
    }
    r.open("POST", "process/process18.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("ProductId=" + id + "&BuyQty=" + qt);
}

function SetMainImg(z) {
    var InSmall = document.getElementById(z);
    var InMain = document.getElementById("MainImg");
    InMain.src = InSmall.src;
}

function SearchInWatchlist() {
    var WatchListSearch = document.getElementById("WatchListSearch").value;
    var WatchListSearchFill = document.getElementById("WatchListSearchFill");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text19 = r.responseText;
            WatchListSearchFill.innerHTML = text19;
        }
    }
    r.open("POST", "process/process19.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("SearchVal=" + WatchListSearch);
}

function CopytoShere(ur) {
    var copyText = document.getElementById("ShereProduct");
    navigator.clipboard.writeText(ur);
    copyText.classList.add("text-warning");
    AlertSuccess('The sharing link was copied to the clipboard');
}

function PayNowHere(id) {
    var num = document.getElementById("QtyNum").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text20 = r.responseText;
            if (text20 == "ER1") {
                AlertDanger('Sign in to the eShop to buy this product.');
                ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');
            } else if (text20 == "ER2") {
                AlertDanger('Request was rejected due to the quantity.');
            } else if (text20 == "ER3") {
                AlertDanger('Update eShop Profile to buy this product.');
                ApplyAlertBtn('alertnobtn', 'userprofile.php', 'Profile Page', 'btn-danger');
            } else {
                var Object = JSON.parse(text20);
                // Called when user completed the payment. It can be a successful payment or failure
                payhere.onCompleted = function onCompleted(orderId) {
                    PaySuccess(Object);
                };

                // Called when user closes the payment without completing
                payhere.onDismissed = function onDismissed() {
                    //Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Called when error happens when initializing payment such as invalid parameters
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1218077", // Replace your Merchant ID
                    "return_url": undefined, // Important
                    "cancel_url": undefined, // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": Object["id"],
                    "items": Object["item"],
                    "amount": Object["amount"],
                    "currency": "LKR",
                    "first_name": Object["fname"],
                    "last_name": Object["lname"],
                    "email": Object["email"],
                    "phone": Object["mobile"],
                    "address": Object["address"],
                    "city": Object["city"],
                    "country": "Sri Lanka",
                    "delivery_address": Object["address"],
                    "delivery_city": Object["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": Object["product_id1"],
                    "custom_2": ""
                };

                payhere.startPayment(payment);
            };
        }
    }
    r.open("POST", "process/process20.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("ProductId=" + id + "&ProductQty=" + num);
}

function ShowCatItem(t) {
    var ShowCatProd = document.getElementById(t);
    var BasicSearchCategory = document.getElementById("BasicSearchCategory");
    BasicSearchCategory.innerHTML = ShowCatProd.innerHTML;
    BasicSearchCategory.value = ShowCatProd.value;
}

function BasicSearch(pg) {
    var BasicSearchFill = document.getElementById("BasicSearchFill");
    var SearchItems = document.getElementById("SearchItems").value;
    var BasicSearchCategory = document.getElementById("BasicSearchCategory").value;
    if (pg == null) {
        pg = 1;
    }
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text23 = r.responseText;
            BasicSearchFill.innerHTML = text23;
        }
    }
    r.open("POST", "process/process23.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("SearchItems=" + SearchItems + "&BasicSearchCategory=" + BasicSearchCategory + "&pg=" + pg);
}

function MoveToRecentCart(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text24 = r.responseText;
            if (text24 == "ER1") {
                AlertDanger('Sign in to remove this product from the WishList.');
                ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');
            } else {
                window.location = "cart.php";
            }
        }
    }
    r.open("POST", "process/process24.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("ProductId=" + id);
}

function QtyPlusCart(sc) {
    var a = 1;
    var b = 1;
    var num = document.getElementById("QtyCartNum" + sc);
    var QtyNum = document.getElementById("QtyCartMax" + sc);
    a = parseInt(num.value, 10);
    b = parseInt(QtyNum.innerText, 10);
    if (a < b) {
        a++;
        a = (a < 10) ? "0" + a : a;
        num.value = a;
    } else if (a >= b) {
        b = (b < 10) ? "0" + b : b;
        num.value = b;
    } else {
        num.value = b;
    }
    document.getElementById("Visible" + sc).classList.remove("visible-hidden");
}

function QtyMinusCart(sc) {
    var a = 1;
    var b = 1;
    var num = document.getElementById("QtyCartNum" + sc);
    var QtyNum = document.getElementById("QtyCartMax" + sc);
    a = parseInt(num.value, 10);
    b = parseInt(QtyNum.innerText, 10);
    if (a > b) {
        b = (b < 10) ? "0" + b : b;
        num.value = b;
    } else if (a > 0) {
        a--;
        a = (a < 10) ? "0" + a : a;
        num.value = a;
    } else if (a < 0) {
        num.value = 01;
    } else if (a == 0) {
        num.value = '00';
    } else if (a == b) {
        num.value = '01';
    } else {
        num.value = '00';
    }
    document.getElementById("Visible" + sc).classList.remove("visible-hidden");
}

function ProfileMsg() {
    AlertDanger('Update eShop Profile to buy this products.');
    ApplyAlertBtn('alertnobtn', 'userprofile.php', 'Profile Page', 'btn-danger');
}

function CartCheckout() {
    var CheckoutFill = document.getElementById("CheckoutFill");

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text25 = r.responseText;
            CheckoutFill.innerHTML = text25;
        }
    }
    r.open("POST", "process/process25.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send();
}

function PayCartHere() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text26 = r.responseText;
            if (text26 == "ER1") {
                AlertDanger('Sign in to the eShop to buy this product.');
                ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');
            } else if (text26 == "ER2") {
                AlertDanger('Request was rejected due to the quantity.');
            } else if (text26 == "ER3") {
                AlertDanger('Update eShop Profile to buy this product.');
                ApplyAlertBtn('alertnobtn', 'userprofile.php', 'Profile Page', 'btn-danger');
            } else {
                var Object = JSON.parse(text26);
                // Called when user completed the payment. It can be a successful payment or failure
                payhere.onCompleted = function onCompleted(orderId) {
                    PaySuccess(Object);
                };

                // Called when user closes the payment without completing
                payhere.onDismissed = function onDismissed() {
                    alert("Payment dismissed");
                    //Note: Prompt user to pay again or show an error page
                    // console.log("Payment dismissed");
                };

                // Called when error happens when initializing payment such as invalid parameters
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    // console.log("Error:" + error);
                    alert("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1218077", // Replace your Merchant ID
                    "return_url": undefined, // Important
                    "cancel_url": undefined, // Important
                    "notify_url": "http://localhost/E-Shop/notify.php",
                    "order_id": Object["id"],
                    "items": Object["item"],
                    "amount": Object["amount"],
                    "currency": "LKR",
                    "first_name": Object["fname"],
                    "last_name": Object["lname"],
                    "email": Object["email"],
                    "phone": Object["mobile"],
                    "address": Object["address"],
                    "city": Object["city"],
                    "country": "Sri Lanka",
                    "delivery_address": Object["address"],
                    "delivery_city": Object["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                payhere.startPayment(payment);
            };
        }
    }
    r.open("POST", "process/process26.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send();
}

function OpenCartPop(it) {
    var ShowPop = document.getElementById(it);
    var it = new bootstrap.Popover(ShowPop, { trigger: 'hover focus' });
    it.show();
}

function addfeedback(id) {
    modelshow = new bootstrap.Modal(document.getElementById("feedbackmodal" + id), { backdrop: 'static', keyboard: false });
    modelshow.show();
}

function savefeedback(id, pid) {
    var Feedback = document.getElementById("feedtxt" + id).value;
    var DatePurcased = document.getElementById("DatePurcased" + id).innerText;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text27 = r.responseText;
            if (text27 == "ER1") {
                AlertDanger('We are unable to find your product.');
            } else if (text27 == "SA1") {
                AlertSuccess('Your feedback reported successfully.');
                modelshow.hide();
            } else {
                AlertDanger('Something went wrong in here.');
            }
        }
    }
    r.open("POST", "process/process27.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Feedbackid=" + pid + "&Feedback=" + Feedback + "&DatePurchased=" + DatePurcased);
}

function clearinvoice(id) {
    if (id == null) {
        id = 0;
    }
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text28 = r.responseText;
            window.location = "purchasehistory.php";
        }
    }
    r.open("POST", "process/process28.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Productid=" + id);
}

function PaySuccess(Object) {
    var s = new XMLHttpRequest();
    s.onreadystatechange = function() {
        if (s.readyState == 4) {
            var text50 = s.responseText;
            if (text50 == "SA1") {
                AlertSuccess('best wishes! Your payment is successful.');
                ApplyAlertBtn('alertokbtn', 'invoice.php', 'Invoice Page', 'btn-success');
            } else {
                AlertDanger(text50);
            }
        }
    }
    s.open("POST", "process/process50.php", true);
    s.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    s.send("orderId=" + Object["id"] + "&ProductQty=" + Object["product_qty"] + "&Total=" + Object["amount"] + "&productId=" + Object["payproductid"]);
}

function printinvoice() {
    var page = document.getElementById("Printpage").innerHTML;
    var printWindow = window.open("", "", "width=800, height=600");
    printWindow.document.write(page);
}

function AdminVerify() {
    var Adminemail = document.getElementById("AdminEmail");

    var t = new XMLHttpRequest();
    swal({ title: "Wait for Status", });
    t.onreadystatechange = function() {
        if (t.readyState == 4) {
            var text3 = t.responseText;
            if (text3 == "Please enter your email address") {
                swal({ title: text3, });
            }
            if (text3 == "Message has been sent.") {
                swal({ title: text3, });
                modelshow = new bootstrap.Modal(document.getElementById("AdminModel"), { backdrop: 'static', keyboard: false });
                modelshow.show();
            } else {
                swal({ title: text3, });
            }
        }
    };

    t.open("POST", "process/process29.php", true);
    t.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    t.send("AdminEmail=" + Adminemail.value);
}

function AdminLogIn() {
    var Adminemail = document.getElementById("AdminEmail");
    var Verify = document.getElementById("AdminVerify");
    var Adminremember = document.getElementById("Adminremember");
    var Rem = 0;
    if (Adminremember.checked) {
        Rem = 1;
    }
    var t = new XMLHttpRequest();
    t.onreadystatechange = function() {
        if (t.readyState == 4) {
            var text30 = t.responseText;
            if (text30 == "SA1") {
                window.location = "adminpanel.php";
            } else {
                AlertDanger(text30);
            }
        }
    };

    t.open("POST", "process/process30.php", true);
    t.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    t.send("AdminEmail=" + Adminemail.value + "&VerifyId=" + Verify.value + "&RememberId=" + Rem);
}

function UserStatus(mail) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text31 = r.responseText;
            AlertDanger(text31);
        }
    }
    r.open("POST", "process/process31.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Email=" + mail);
}

function AdminProductStatus(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text32 = r.responseText;
            AlertDanger(text32);
        }
    }
    r.open("POST", "process/process32.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Product=" + id);
}

function AdminProductView(id) {
    modelshow = new bootstrap.Modal(document.getElementById("AdminProductModel" + id), { backdrop: 'static', keyboard: false });
    modelshow.show();
}

function sendmessage(mail, ms) {
    var msgtxt;
    if (ms == null) {
        msgtxt = document.getElementById("msgtxt").value;
    } else {
        msgtxt = document.getElementById("msgtxt" + ms).value;
    }

    var Msgform = new FormData();
    Msgform.append("receiver", mail);
    Msgform.append("massage", msgtxt);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text33 = r.responseText;
            if (text33 == "success") {
                if (ms == null) {
                    RefreshmsgArea(mail);
                } else {
                    window.location = "manageusers.php";
                }
            } else {
                alert(text33);
            }
        }
    }
    r.open("POST", "process/process33.php", true);
    r.send(Msgform);
}
var msgpg;

function SelectUserMsg(email) {
    if (msgpg == null) {
        msgpg = 1;
    }
    var MsgUserFill = document.getElementById("MsgUserFill");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text34 = r.responseText;
            MsgUserFill.innerHTML = text34;
            RefreshmsgArea(email);
            RefreshTypeArea(email);
            reCallme(email);
        }
    }
    r.open("POST", "process/process34.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Email=" + email + "&page=" + msgpg);
}

function SelectUserMsgPg(pg) {
    msgpg = pg;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text34 = r.responseText;
            MsgUserFill.innerHTML = text34;
            RefreshmsgArea('admin');
            RefreshTypeArea('admin');
            reCallme('admin');
        }
    }
    r.open("POST", "process/process34.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Email=" + 'admin' + "&page=" + pg);
}

var myInterval;
var ReciveText;

function reCallme(email) {
    var foo = function() {
        clearInterval(myInterval);
    };
    foo();
    myInterval = setInterval(function() {
        RefreshmsgArea(email);
        // alert("hi call me ?" + email);
    }, 1500);
}

function RefreshmsgArea(mail) {
    var chatrow = document.getElementById("chatFillrow");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text35 = r.responseText;
            if (ReciveText == text35) {} else {
                ReciveText = text35;
                chatrow.innerHTML = text35;
                GoChatEnd();
            }
        }
    }
    r.open("POST", "process/process35.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Email=" + mail);
}

function GoChatEnd() {
    var chatbox = document.getElementById("chat-box");
    chatbox.scrollTop = 20000;
}

function MarkAsReadAdmin(mail) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text40 = r.responseText;
            window.location = "manageusers.php";
        }
    }
    r.open("POST", "process/process40.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Email=" + mail);
}

function RefreshTypeArea(mail) {
    var typerow = document.getElementById("TypeFillrow");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text36 = r.responseText;
            typerow.innerHTML = text36;
        }
    }
    r.open("POST", "process/process36.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Email=" + mail);
}

function AddNew(id, type) {
    var namevalue = document.getElementById(id).value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text37 = r.responseText;
            if (text37 == "SA1") {
                AlertSuccess('Successfully Listed in Database.');
            } else {
                AlertDanger(text37);
            }
        }
    }
    r.open("POST", "process/process37.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Name=" + namevalue + "&Type=" + type);
}

function BrandInCategory() {
    var AdCateId = document.getElementById("AdCateId").value;
    var AdBrandId = document.getElementById("AdBrandId").value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text38 = r.responseText;
            if (text38 == "SA1") {
                AlertSuccess('Successfully Listed in Database.');
            } else {
                AlertDanger(text38);
            }
        }
    }
    r.open("POST", "process/process38.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("CateId=" + AdCateId + "&BrdId=" + AdBrandId);
}

function AdNewModel() {
    var CateId = document.getElementById("dropdownMenuButton1").value;
    var BrandId = document.getElementById("dropdownMenuButton2").value;
    var ModelName = document.getElementById("NewModelAd").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text39 = r.responseText;
            if (text39 == "SA1") {
                AlertSuccess('Successfully Listed in Database.');
            } else {
                AlertDanger(text39);
            }
        }
    }
    r.open("POST", "process/process39.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("CateId=" + CateId + "&BrdId=" + BrandId + "&Model=" + ModelName);
}

function AdminUserView(id) {
    modelshow = new bootstrap.Modal(document.getElementById("AdminUserMsgModel" + id), { backdrop: 'static', keyboard: false });
    modelshow.show();
}

function SearchinSellad() {
    var dayon = document.getElementById("AdminsellSearchon").value;
    var dayto = document.getElementById("AdminsellSearchto").value;
    var SellBodyFill = document.getElementById("SellBodyFill");

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text41 = r.responseText;
            SellBodyFill.innerHTML = text41;
        }
    }
    r.open("POST", "process/process41.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("dayon=" + dayon + "&dayto=" + dayto);
}

function DeleteRecent(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text42 = r.responseText;
            window.location = "recent.php";
        }
    }
    r.open("POST", "process/process42.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Recent=" + id);
}

function AdminUserSearch() {
    var user = document.getElementById("AdminUserSearch").value;
    var AdminUserFill = document.getElementById("AdminUserFill");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text43 = r.responseText;
            AdminUserFill.innerHTML = text43;
        }
    }
    r.open("POST", "process/process43.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("User=" + user);
}

function AdminProductSearch() {
    var product = document.getElementById("AdminProductSearch").value;
    var AdminProductFill = document.getElementById("AdminProductFill");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text44 = r.responseText;
            AdminProductFill.innerHTML = text44;
        }
    }
    r.open("POST", "process/process44.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Product=" + product);
}

function UserCartSearch() {
    var val = document.getElementById("cartSearch").value;
    var FillArea = document.getElementById("UserCartFill");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text45 = r.responseText;
            FillArea.innerHTML = text45;
        }
    }
    r.open("POST", "process/process45.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Val=" + val);
}

function UserRecentSearch() {
    var val = document.getElementById("recentListSearch").value;
    var FillArea = document.getElementById("RecentSearchFill");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text46 = r.responseText;
            FillArea.innerHTML = text46;
        }
    }
    r.open("POST", "process/process46.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("Val=" + val);
}

function check() {

    // alert("clicked");
    // AlertSuccess('Product Listed Successfully.');
    // alertSuccessclose();
    // AlertDanger(text1);
    // alertDangerclose();
    // ApplyAlertBtn('alertnobtn', 'index.php?Sign_In', 'Sign In Page', 'btn-danger');

}