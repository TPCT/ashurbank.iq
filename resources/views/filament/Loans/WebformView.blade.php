<div class="grid gap-6 md:grid-cols-3">
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang("Loan Type")</label>
        <input disabled class="disabled bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$record->loan?->title}}"/>
    </div>
    @foreach($record->getAttributes() as $attribute => $value)
        @continue(in_array($attribute, ['id', 'loan_id', 'created_at', 'updated_at']) || !$value)
        <div>
            <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ucfirst(str_replace('_', ' ', __($attribute)))}}</label>
            <input disabled class="disabled bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$value}}" />
        </div>
    @endforeach
</div>

