@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection

@section('header-content')
<div class="logout__item">
<a href="/login" >
    <button class="logout__button">logout</button>
</a>
</div>
@endsection

@section('content')
<p class="admin__title">Admin</p>
<div class=admin__content>
<form action="{{ route('admin.contacts.index') }}" method="get" class="admin__search--form" novalidate>
    <div class="admin__search--items">
    <input type="text" name="keyword" value="{{ $filters['keyword'] ?? '' }}" placeholder="名前やメールアドレスを入力してください" class="admin__search--text">
    <select name="gender">
        <option value="" disabled selected>性別</option>
        <option value="all"{{ $filters['gender'] === 'all' ? ' selected' : '' }}>全て</option>
        <option value="男性"{{ $filters['gender'] === '男性' ? ' selected' : '' }}>男性</option>
        <option value="女性"{{ $filters['gender'] === '女性' ? ' selected' : '' }}>女性</option>
        <option value="その他"{{ $filters['gender'] === 'その他' ? ' selected' : '' }}>その他</option>
    </select>

    <select name="category_id">
        <option disabled selected>お問い合わせの種類</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}"
            {{ (string)($filters['category_id'] ?? '')
            === (string)$category->id ? ' selected' : '' }}>{{ $category->content }}</option>
        @endforeach
    </select>
    <input type="date" name="date" value="{{ $filters['date'] ?? '' }}" class="admin__calender">
    <div class="admin__buttons">
        <button type="submit" class="search__button">検索</button>
    </div>
    <a href="{{ route('admin.contacts.index') }}">
        <button type="button" class="reset__button">リセット</button>
    </a>
    </div>
    </div>
    </form>
    <div class="admin__table--container">
    <div class="admin__export--button">
    <a href="{{ route('admin.contacts.export', request()->query()) }}" class="export__button">CSVエクスポート</a>
    </div>

    <div class="pagination__links">
  {{ $contacts->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
    </div>

    <table class="table__result">
        <thead>
        <tr class="table__heading">
            <th class="heading__name">お名前</th>
            <th class="heading__gender">性別</th>
            <th class="heading__mail">メールアドレス</th>
            <th class="heading__category">お問い合わせの種類</th>
            <th class="heading__blank"></th>
        </tr>
        </thead>
        @forelse($contacts as $contact)
        <tr class="table__row">
            <td>{{$contact->last_name}} {{$contact->first_name}}</td>
            <td>{{$contact->gender}}</td>
            <td>{{$contact->email}}</td>
            <td>{{ ($contact->category)->content }}</td>
            <td class="table__data--detail--box">
                <button type="button" class="table__data--detail js-show-detail" data-id="{{ $contact->id }}">詳細</button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="no__data">該当するデータがありません。</td>
        </tr>
        @endforelse
    </table>

    <div id="detailModal" class="fl-modal is-hidden" aria-hidden="true">
  <div class="fl-modal__backdrop js-close" aria-label="閉じる背景"></div>
  <div class="fl-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <button type="button" class="fl-modal__close js-close" aria-label="閉じる">×</button>

    <dl class="fl-modal__body">
      <dt>お名前</dt><dd id="m-name"></dd>
      <dt>性別</dt><dd id="m-gender"></dd>
      <dt>メールアドレス</dt><dd id="m-email"></dd>
      <dt>電話番号</dt><dd id="m-tel"></dd>
      <dt>住所</dt><dd id="m-address"></dd>
      <dt>建物名</dt><dd id="m-building"></dd>
      <dt>お問い合わせの種類</dt><dd id="m-category"></dd>
      <dt>お問い合わせ内容</dt><dd id="m-detail" style="white-space: pre-wrap;"></dd>
    </dl>
    <form id="deleteForm" method="POST" class="fl-modal__actions">
  @csrf
  @method('DELETE')
  <button type="submit" class="fl-btn fl-btn--danger"
          onclick="return confirm('このお問い合わせを削除します。よろしいですか？');">
    削除
  </button>
</form>
  </div>
</div>
</div>


<script>
(() => {
  const modal = document.getElementById('detailModal');
  const closeEls = modal.querySelectorAll('.js-close');

  // モーダルの各フィールド
  const els = {
    name: document.getElementById('m-name'),
    gender: document.getElementById('m-gender'),
    email: document.getElementById('m-email'),
    tel: document.getElementById('m-tel'),
    address: document.getElementById('m-address'),
    building: document.getElementById('m-building'),
    category: document.getElementById('m-category'),
    detail: document.getElementById('m-detail'),
  };

  function openModal(){ modal.classList.remove('is-hidden'); document.body.style.overflow = 'hidden'; }
  function closeModal(){ modal.classList.add('is-hidden'); document.body.style.overflow = ''; }

  closeEls.forEach(el => el.addEventListener('click', closeModal));
  document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape' && !modal.classList.contains('is-hidden')) closeModal();
  });

  document.querySelectorAll('.js-show-detail').forEach(button => {
    button.addEventListener('click', async () => {
      const id = button.dataset.id;
      try {
        const urlBase = `{{ route('admin.contacts.index') }}`; // 例) /admin/contacts
        const res = await fetch(`${urlBase}/${id}`, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) throw new Error('Network error');

        const data = await res.json();
        els.name.textContent     = data.name     ?? '';
        els.gender.textContent   = data.gender   ?? '';
        els.email.textContent    = data.email    ?? '';
        els.tel.textContent      = data.tel      ?? '';
        els.address.textContent  = data.address  ?? '';
        els.building.textContent = data.building ?? '';
        els.category.textContent = data.category ?? '';
        els.detail.textContent   = data.detail   ?? '';

        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `${urlBase}/${id}`;

        openModal();
      } catch (err) {
        alert('詳細の取得に失敗しました。');
        console.error(err);
      }
    });
  });
})();
</script>


@endsection


@livewire('contact-modal')