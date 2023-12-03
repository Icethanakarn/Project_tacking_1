const form = document.querySelector('form');
       
       form.addEventListener('submit', (event) => {
        
       
         const projectname = form.querySelector('#projectname');
         const employeesid = form.querySelector('#employeesid');
         const info = form.querySelector('#detail');
         const timeend = form.querySelector('#deadline');
      
       
         if (!projectname.value) {
           projectname.classList.add('is-invalid');
           event.preventDefault();
         } else {
            projectname.classList.remove('is-invalid');
           projectname.classList.add('is-valid');
         }
       
         if (!employeesid.value) {
           employeesid.classList.add('is-invalid');
           event.preventDefault();
         } else {
           employeesid.classList.remove('is-invalid');
           employeesid.classList.add('is-valid');
         }
         if (!info.value) {
           info.classList.add('is-invalid');
           event.preventDefault();
         } else {
           info.classList.remove('is-invalid');
           info.classList.add('is-valid');
         }
         if (!timeend.value) {
           timeend.classList.add('is-invalid');
           event.preventDefault();
         } else {
           timeend.classList.remove('is-invalid');
           timeend.classList.add('is-valid');
         }
     
       });

      // จำกัดการแสดงผลdatalist
       var search = document.querySelector('#employeesid');
var results = document.querySelector('#emp');
var templateContent = document.querySelector('#resultstemplate').content;
search.addEventListener('keyup', function handler(event) {
    while (results.children.length) results.removeChild(results.firstChild);
    var inputVal = new RegExp(search.value.trim(), 'i');
    var clonedOptions = templateContent.cloneNode(true);
    var set = Array.prototype.reduce.call(clonedOptions.children, function searchFilter(frag, el) {
        if (inputVal.test(el.textContent) && frag.children.length < 5) frag.appendChild(el);
        return frag;
    }, document.createDocumentFragment());
    results.appendChild(set);
});