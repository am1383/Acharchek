<?php

namespace App\Modules\SMS\Services;

use App\Modules\SMS\Models\SMSPack;
use App\Modules\SMS\Repositories\Contracts\SMSPackRepositoryInterface;
use App\Modules\SMS\Services\Contracts\SMSPackServiceInterface;

class SMSPackService implements SMSPackServiceInterface
{
    public function __construct(private SMSPackRepositoryInterface $sMSPackRepository) {}

    public function getDetailsById(int $id): SMSPack
    {
        return $this->sMSPackRepository
            ->findOrFail($id);
    }

    public function getSMSPacks(string $appVersion): array
    {
        $smsPacks = $this->sMSPackRepository->get();
        $appVersion = $this->normalizeAppVersion($appVersion);

        if ($this->shouldIncludeFaq($appVersion)) {
            return $this->formatResponse(true, [
                'sms_packs' => $smsPacks,
                'faq' => $this->getFaq(),
            ]);
        }

        return $this->formatResponse(true, $smsPacks);
    }

    private function normalizeAppVersion(string $version): int
    {
        return (is_numeric($version)) ? (int) $version : 0;
    }

    private function shouldIncludeFaq(int $appVersion): bool
    {
        return $appVersion >= 210000605;
    }

    private function getFaq(): array
    {
        $fd1 = 'برنامه آچارچک در زمان ثبت هر سرویس جدید و یادآوری برای مشتری شما به صورت خودکار پیامک ارسال میکند و همچنین شما میتوانید به مشتریان خود به صورت انفرادی یا گروهی پیامک دلخواه ارسال نمایید و جهت ارسال شدن پیامک ها لازم است اعتبار پیامکی کافی داشته باشید.';
        $fd1 .= ' بعد از ثبت هر سرویس برای مشتری در آچارچک ، بلافاصله یک پیامک بازدید و در زمان مشخص شده یک پیامک یادآوری به صورت خودکار ارسال میگردد و درصورت عدم داشتن اعتبار پیامکی کافی ، پیامک یادآوری و بازدید برای مشتریان شما ارسال نمیشود.';

        $fd2 = 'استفاده از اعتبار پیامکی محدودیت زمانی ندارد و میتوانید از اعتبار پیامکی در مدت زمان نامحدود استفاده کنید.';
        $fd2 .= ' در این برنامه فقط بابت ثبت سرویس جدید ، یادآوری سرویس و ارسال پیامک تکی یا گروهی به مشتریان از اعتبار پیامکی شما کسر میگردد و سایر بخش های برنامه مانند ثبت مشتری ، ویرایش مشتری ، ویرایش سرویس ، مشاهده گزارشات و ... 100% رایگان می باشد.';
        $fd2 .= ' و به ازای ثبت هر سرویس و ارسال یادآوری باتوجه به اینکه طول پیامک ارسالی 3 بخش می باشد مبلغ ۵۰۰ تومان از اعتبار شما کسر میگردد.';

        return [
            [
                'title' => 'اعتبار پیامکی چیست و چرا باید اعتبار پیامکی خریداری کنم ؟',
                'desc' => $fd1,
            ],
            [
                'title' => 'بابت چه مواردی از مبلغ اعتبار من کسر میگردد و آیا استفاده از اعتبار پیامکی محدودیت زمانی ندارد ؟',
                'desc' => $fd2,
            ],
        ];
    }

    private function formatResponse(bool $status, mixed $data): array
    {
        return [
            'status' => $status,
            'data' => $data,
        ];
    }
}
