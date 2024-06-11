function scrollToContact(contactId) {
    
    const contactSection = document.getElementById(contactId);
    const contactSectionTop = contactSection.offsetTop - 100; 

   
    window.scrollTo({
        top: contactSectionTop,
        behavior: 'smooth'
    });
}

window.onscroll = function() {scrollFunction()};

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scrollTopBtn").classList.add("showBtn");
    } else {
        document.getElementById("scrollTopBtn").classList.remove("showBtn");
    }
}