const changeInputField = (checkbox, index, id) => {
  if(index <= 4 && index > 0) {
    input = document.querySelector(`#${id} > div:nth-child(${index + 2}) > div.col-xs-6.col-sm-10.col-md-11 > input`);
    if(input.name === 'wrong_answer[]') {
      input.name = 'correct_answer[]';
      input.classList.remove('wrong_answer');
      input.classList.add('correct_answer');
    } else {
      input.name = 'wrong_answer[]';
      input.classList.remove('correct_answer');
      input.classList.add('wrong_answer');
    }
  }
}

const generateInputFields = (element, id) => {
  let selected = element.value;
  let count = 4;
  if (selected === 'input') {
    count = 1;
  } 
  document.getElementById(id).textContent = ''; 
  if(selected !== '0') {
    let title = document.createElement('h6');
    title.setAttribute('class', 'mb-3 text-center');
    title.textContent = (selected === 'input') ? 'Tačan odgovor' : 'Odgovori';
    document.getElementById(id).appendChild(title);
    
    for(let i = 0; i < count; i++) {
      let firstClass = (i) ? 'wrong_answer' : 'correct_answer',
      isCheckbox = (selected === 'chbox') ? 'col-xs-6 col-sm-10 col-md-11': '',
      row = document.createElement('div'),
      col = document.createElement('div'),
      inputText = document.createElement('input');

      row.setAttribute('class', 'row');

      col.setAttribute('class', isCheckbox);

      inputText.setAttribute('type', 'text');
      inputText.setAttribute('class', `form-control ${firstClass} mb-1`);
      inputText.setAttribute('name', `${firstClass}[]`);

      col.appendChild(inputText);
      row.appendChild(col);
      
      if(selected === 'chbox') {
        col = document.createElement('div'),
        checkbox = document.createElement('input'),
        label    = document.createElement('label');

        col.setAttribute('class', 'col-xs-6 col-sm-2 col-md-1 mt-1');

        checkbox.setAttribute('type', 'checkbox');
        checkbox.setAttribute('class', 'form-check-input');
        checkbox.setAttribute('onclick', `changeInputField(this, ${i}, '${id}')`);

        if(i === 0) {
          checkbox.setAttribute('disabled', '');
          checkbox.setAttribute('checked', '');
        }

        col.appendChild(checkbox);
        row.appendChild(col);
        document.getElementById(id).appendChild(row);
      }

      document.getElementById(id).appendChild(row);
      
    }



  }
}
