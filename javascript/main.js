function search(name) {
  fetchSearchData(name);
}

function fetchSearchData(name) {
  fetch("includes/search.inc.php", {
    method: "post",
    body: new URLSearchParams("name=" + name),
  })
    .then((res) => res.json())
    .then((res) => viewSearchResult(res))
    .catch((e) => console.error("Error" + e));
}

function getNomeCognome(data) {
  var lenght = Object.keys(data).length;
  var spazio = -1;
  for (let i = lenght - 1; i >= 0; i--) {
    if (data[i] == " ") {
      spazio = i;
      break;
    }
  }
  if (spazio != -1) {
    var nome = "";
    var cognome = "";
    for (let i = 0; i < spazio; i++) {
      cognome += data[i];
    }
    for (let i = spazio + 1; i < lenght; i++) {
      nome += data[i];
    }
    return [nome, cognome];
  } else {
    return 0;
  }
}

function makeFirstUpper(data) {
  var lenght = Object.keys(data).length;
  if (lenght == 0) {
    return 0;
  }
  var nome = data[0].toUpperCase();
  for (let i = 1; i < lenght; i++) {
    if (data[i - 1] == " ") {
      nome += data[i].toUpperCase();
    } else {
      nome += data[i];
    }
  }
  return nome;
}

function viewSearchResult(data) {
  var lenght = Object.keys(data).length;
  const dataViewer = document.getElementById("dataViewer");
  dataViewer.innerHTML = "";
  if (data != 0) {
    for (let i = 0; i < lenght; i++) {
      var nomecognome = getNomeCognome(data[i]);
      if (nomecognome != 0) {
        var nome = makeFirstUpper(nomecognome[0]);
        var cognome = makeFirstUpper(nomecognome[1]);
        const li = document.createElement("li");
        const a = document.createElement("a");
        a.href = "atleta.php?nome=" + nome + "&cognome=" + cognome;
        a.innerHTML = nome + " " + cognome;
        li.appendChild(a);
        dataViewer.appendChild(li);
      }
    }
  }
}
