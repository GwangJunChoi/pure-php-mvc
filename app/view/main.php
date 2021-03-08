<main>
    <div class="board-wrapper">
        <ul class="board-list"></ul>
        <nav class="board-pagnation">
            <div><i class="fas fa-long-arrow-alt-left"></i></div>
            <div>1</div>
            <div class="active">2</div>
            <div>3</div>
            <div>4</div>
            <div><i class="fas fa-long-arrow-alt-right"></i></div>
        </nav>
    </div>
    <div class="board-add-container">
        <form id="board-form">
            <fieldset>
                <label for="title">title</label>
                <input type="text" class="board-form" id="title" name="title">
                <label for="author">author</label>
                <input type="text" class="board-form" id="author" name="author">
                <label for="password">password</label>
                <input type="password" class="board-form" id="password" name="password">
                <label for="content">content</label>
                <textarea id="content" class="board-form" name="content"></textarea>
                <button type="button" class="btn block w100 form-submit" onclick="boardForm.register();">save</button>
                <button type="button" class="btn block w100 mgt10 add-form-close" onclick="boardForm.hide();">close</button>
                <button type="button" class="btn block w100 mgt10 remove-board" onclick="boardForm.remove(this);">remove</button>
            </fieldset>
        </form>
    </div>
    <nav class="board-nav">
        <div class="add-btn" onclick="boardForm.showWriteForm();"><i class="far fa-plus-square" aria-hidden="true"></i></div>
    </nav>
</main>
<script>
    const boardData = {
      currentPage: 1,
      total: 0,
      maxPage: 5,
      boards: [],
      params: {
        offset: 0,
        limit: 5,
      },
    };

    const boardForm = {
      element: document.querySelector('.board-add-container'),
      showViewForm: (data) => {
        document.querySelector('#title').value = data.title;
        document.querySelector('#author').value = data.author;
        document.querySelector('#content').value = data.content;
        document.querySelector('#password').value = '';
        document.querySelector('.remove-board').style.setProperty('display', 'block');
        document.querySelector('.remove-board').setAttribute('remove-id', data.id);
        document.querySelector('.form-submit').setAttribute('onclick', `boardForm.update("${data.id}");`);
        boardForm.show();
      },
      showWriteForm: () => {
        document.querySelector('#title').value = '';
        document.querySelector('#author').value = '';
        document.querySelector('#password').value = '';
        document.querySelector('#content').value = '';
        document.querySelector('.remove-board').style.setProperty('display', 'none');
        document.querySelector('.form-submit').setAttribute('onclick', `boardForm.register();`);
        boardForm.show();
      },
      show: () => {
        boardForm.element.style.setProperty('transform', 'translate(0, 0)');
      },
      hide: () => boardForm.element.style.setProperty('transform', 'translate(0, -100%)'),
      update: (id) => {
        const formData = new FormData(document.querySelector('#board-form'));
        const data = {};
        for (let [key, value] of formData.entries()) {
          data[key] = value;
        }
        fetch(`/board/${id}`, {
          headers: {
            'Content-Type': 'application/json'
          },
          method: 'PUT',
          body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(response => {
          alert(response.msg);
          if (response.result) {
              board.getBoards();
          }
        })
        .catch(error => console.error('Error:', error));
      },
      remove: (target) => {
        const id = target.getAttribute('remove-id');
        fetch(`/board/${id}`, {
          headers: {
            'Content-Type': 'application/json'
          },
          method: 'DELETE',
          body: JSON.stringify({ password:document.querySelector('#password').value }),
        })
        .then(response => response.json())
        .then(response => {
          alert(response.msg);
          if (response.result) {
            board.getBoards();
            boardForm.hide();
          }
        })
        .catch(error => console.error('Error:', error));
      },
      register: () => {
        boardForm.submit('/board', 'POST', () => {
          board.getBoards();
          boardForm.hide();
        });
      },
      submit: (url, method, callback) => {
        const data = new FormData(document.querySelector('#board-form'));
        fetch(url, {
          method: method,
          body: data
        })
        .then(response => response.json())
        .then(response => {
          alert(response.msg);
          if (response.result) {
            if (typeof callback === 'function') {
                callback(response);
            }
          }
        })
        .catch(error => console.error('Error:', error));
      }
    };
    const pagination = {
      element: document.querySelector('.board-pagnation'),
      setPaging: () => {
        const lastPage = Math.ceil(boardData.total / boardData.params.limit);
        const pageGroup = Math.ceil(boardData.currentPage / boardData.maxPage);
        const lastGroup = Math.ceil(lastPage / boardData.maxPage);
        let startCount = (pageGroup - 1) * boardData.maxPage;
        let endCount = pageGroup * boardData.maxPage;
        endCount = (endCount > lastPage) ? lastPage : endCount;

        const leftActive =  (boardData.currentPage <= boardData.maxPage) ? 'active' : '';
        const rightActive =  (pageGroup === lastGroup) ? 'active' : '';

        let pageText = '';
        pageText += `<div class="${leftActive}"><i class="fas fa-long-arrow-alt-left" page="${startCount}"></i></div>`;
        for (let i = ++startCount; i <= endCount; i++) {
            pageText += `<div page="${i}">${i}</div>`;
        }
        pageText += `<div class="${rightActive}"><i class="fas fa-long-arrow-alt-right" page="${++endCount}"></i></div>`;
        pagination.element.innerHTML = pageText;
        document.querySelector(`[page="${boardData.currentPage}"]`).setAttribute('class','active');

        Array.from(document.querySelectorAll('[page]'))
          .map(element => element.addEventListener('click', pagination.gotoPage, false));
      },
      gotoPage: (event) => {
        const currentPage = event.target.getAttribute('page');
        boardData.currentPage = currentPage;
        boardData.params.offset = (currentPage - 1) * boardData.params.limit;
        board.getBoards();
      },
    }

    const board = {
      container: document.querySelector('.board-list'),
      getBoards: () => {
        fetch(`/board?${new URLSearchParams(boardData.params).toString()}`, {
          method: 'GET',
        })
        .then(response => response.json())
        .then(respons => {
          boardData.boards = respons.boards;
          boardData.total = Number.parseInt(respons.total);
          board.render();
        })
        .catch(error => console.error('Error:', error));
      },
      getBoardsNumber: () => {
        return boardData.total - ((boardData.currentPage - 1) * boardData.params.limit);
      },
      render: () => {
        if (boardData.boards.length === 0) {
          board.container.innerHTML = `<li class="empty">게시글이 없습니다.</li>`;
          return false;
        }
        pagination.setPaging();
        let itemText = '';
        let number = board.getBoardsNumber();
        boardData.boards.forEach((item, index) => {
          itemText += `<li>`;
          itemText += `<div class="board-item">`;
          itemText +=   `<div class="item-header" board-id="${item.id}">${number}. ${item.title}</div>`;
          itemText +=   `<div class="item-content"><p>${item.content}</p></div>`;
          itemText +=   `<div class="item-footer">`;
          itemText +=     `<span>${item.author}</span> / `;
          itemText +=     `<span>${item.inserted_at}</span> `;
          itemText += `</div>`;
          itemText += `</li>`;
          number--;
        });
        board.container.innerHTML = itemText;
        Array.from(document.querySelectorAll('.board-item [board-id]'))
          .map(element => element.addEventListener('click', board.view, false));
      },
      view: (event) => {
        const id = event.target.getAttribute('board-id');
        fetch(`/board/${id}`, {
          method: 'GET',
        })
        .then(response => response.json())
        .then(respons => {
          boardForm.showViewForm(respons);
        })
        .catch(error => console.error('Error:', error));
      }
    }
document.addEventListener("DOMContentLoaded", () => {
  board.getBoards();
});
</script>
