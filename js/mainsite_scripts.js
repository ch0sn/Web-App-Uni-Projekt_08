/* Ausfahr-Effekt der FilterArea. */
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
}

/* Ausfahr-Effekt für FB01.*/
var coll1 = document.getElementsByClassName("fb01Collapsible");
var i1;

for (i1 = 0; i1 < coll1.length; i1++) {
    coll1[i1].addEventListener("click", function () {
        this.classList.toggle("active");
        var content1 = this.nextElementSibling;
        if (content1.style.maxHeight) {
            content1.style.maxHeight = null;
        } else {
            content1.style.maxHeight = content1.scrollHeight + "px";
        }
    });
}


/* Ausfahr-Effekt für FB02. */
var coll2 = document.getElementsByClassName("fb02Collapsible");
var i2;
for (i2 = 0; i2 < coll2.length; i2++) {
    coll2[i2].addEventListener("click", function () {
        this.classList.toggle("active");
        var content2 = this.nextElementSibling;
        if (content2.style.maxHeight) {
            content2.style.maxHeight = null;
        } else {
            content2.style.maxHeight = content2.scrollHeight + "px";
        }
    });


}

/* Ausfahr-Effekt für FB03. */
var coll3 = document.getElementsByClassName("fb03Collapsible");
var i3;
for (i3 = 0; i3 < coll3.length; i3++) {
    coll3[i3].addEventListener("click", function () {
        this.classList.toggle("active");
        var content3 = this.nextElementSibling;
        if (content3.style.maxHeight) {
            content3.style.maxHeight = null;
        } else {
            content3.style.maxHeight = content3.scrollHeight + "px";
        }
    });


}

/* Ausfahr-Effekt für FB04. */
var coll4 = document.getElementsByClassName("fb04Collapsible");
var i4;
for (i4 = 0; i4 < coll4.length; i4++) {
    coll4[i4].addEventListener("click", function () {
        this.classList.toggle("active");
        var content4 = this.nextElementSibling;
        if (content4.style.maxHeight) {
            content4.style.maxHeight = null;
        } else {
            content4.style.maxHeight = content4.scrollHeight + "px";
        }
    });
}

/* Ausfahr-Effekt für FB05. */
var coll5 = document.getElementsByClassName("fb05Collapsible");
var i5;
for (i5 = 0; i5 < coll5.length; i5++) {
    coll5[i5].addEventListener("click", function () {
        this.classList.toggle("active");
        var content5 = this.nextElementSibling;
        if (content5.style.maxHeight) {
            content5.style.maxHeight = null;
        } else {
            content5.style.maxHeight = content5.scrollHeight + "px";
        }
    });
}

/* Ausfahr-Effekt für FB06. */
var coll6 = document.getElementsByClassName("fb06Collapsible");
var i6;
for (i6 = 0; i6 < coll6.length; i6++) {
    coll6[i6].addEventListener("click", function () {
        this.classList.toggle("active");
        var content6 = this.nextElementSibling;
        if (content6.style.maxHeight) {
            content6.style.maxHeight = null;
        } else {
            content6.style.maxHeight = content6.scrollHeight + "px";
        }
    });
}

/* Ausfahr-Effekt für FB04. */
var coll13 = document.getElementsByClassName("fb13Collapsible");
var i13;
for (i13 = 0; i13 < coll13.length; i13++) {
    coll13[i13].addEventListener("click", function () {
        this.classList.toggle("active");
        var content13 = this.nextElementSibling;
        if (content13.style.maxHeight) {
            content13.style.maxHeight = null;
        } else {
            content13.style.maxHeight = content13.scrollHeight + "px";
        }
    });
}
