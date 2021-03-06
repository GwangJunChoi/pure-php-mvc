<main>
    <div class="board-wrapper">
        <ul class="board-list">
            <li>
                <div class="board-item">
                    <div class="item-header"></div>
                    <div class="item-content">
                        <p>게시물게asdfasdfasdfsda시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물</p>
                    </div> 
                    <div class="item-footer">
                        <span>2020-01-28</span>
                        <span class="btn item-remove"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
                    </div>
                </div>
            </li>
            <li>
                <div class="board-item">
                    <div class="item-header"></div>
                    <div class="item-content">
                        <p>게시물게asdfasdfasdfsda시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물게시물</p>
                    </div>
                    <div class="item-footer">
                        <span>2020-01-28</span>
                        <span class="btn item-remove"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
                    </div>
                </div>
            </li>
        </ul>
        <nav class="board-pagnation"></nav>
    </div>
    <div class="board-add-container">
        <fieldset>
            <legend><h1>test</h1></legend>
            <label for="password">password</label>
            <input type="password" class="board-form" id="password" name="password">
            <label for="content">content</label>
            <textarea id="content" class="board-form" name="content"></textarea>
            <button type="button" class="btn block w100">save</button>
            <button type="button" class="btn block w100 mgt10 add-from-close">close</button>
        </fieldset>
    </div>
    <nav class="board-nav">
        <div class="add-btn"><i class="far fa-plus-square" aria-hidden="true"></i></div>
    </nav>
</main>
<script>
    const boardData = {
        total: 0,
        limit: 10,
        max: 10,
        currentPage: 0,
    };
    const boardAction = {
        data: boardData,
        getCount: () => {
            console.log('getTotalCount');
        },
        getList: () => {
            console.log('getlist');
        },
        setPaging: () => {

        }
    }
document.addEventListener("DOMContentLoaded", () => {
    console.log(simpleBoard);
    const boardForm = document.querySelector('.board-add-container');
    document.querySelector('.add-btn').addEventListener('click', () => {
        boardForm.style.setProperty('transform', 'translate(0, 0)');
    }, false);
    document.querySelector('.add-from-close').addEventListener('click', () => {
        boardForm.style.setProperty('transform', 'translate(0, -100%)');
    }, false);
});
</script>
<?php
echo '<pre>';
print_r($_GET);