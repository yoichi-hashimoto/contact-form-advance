  <div x-data x-cloak>
    <div
      x-show="@js($open)"
      x-transition.opacity
      class="fixed inset-0 z-50 flex items-start justify-center"
      aria-modal="true" role="dialog"
    >
<div class="absolute inset-0 bg-black/50" @click="open = false"></div>

    <div class="relative mt-10 max-w-3xl w-[720px] rounded-2xl bg-white p-6 shadow-xl">
        <button class="fl-modal__close absolute right-3 top-3" @click="open = false" aria-label="閉じる">×</button>

        @if($contact)
        <h2 class="text-xl font-bold mb-4">お問い合わせ詳細</h2>
        <dl class="grid grid-cols-3 gap-y-2">
          <dt class="font-semibold">お名前</dt>
          <dd class="col-span-2">{{ $contact->last_name }} {{ $contact->first_name }}</dd>

          <dt class="font-semibold">性別</dt>
          <dd class="col-span-2">{{ $contact->gender }}</dd>

          <dt class="font-semibold">メール</dt>
          <dd class="col-span-2">{{ $contact->email }}</dd>

          <dt class="font-semibold">電話</dt>
          <dd class="col-span-2">{{ $contact->tel1 }}-{{ $contact->tel2 }}-{{ $contact->tel3 }}</dd>

          <dt class="font-semibold">住所</dt>
          <dd class="col-span-2">{{ $contact->address }}</dd>

          <dt class="font-semibold">お問い合わせ内容</dt>
          <dd class="col-span-2 whitespace-pre-line">{{ $contact->detail }}</dd>
        </dl>

        <div class="mt-6 text-right">
          <button wire:click="delete" class="px-4 py-2 rounded-lg bg-red-600 text-white">削除</button>
        </div>
        @endif
      </div>
    </div>
  </div>
