<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ReportReason;
use App\Models\ReportSubReason;
use Illuminate\Database\Seeder;

class ReportReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create main report reasons (e.g., "Harassment", "Spam")
        $harassment = ReportReason::create(['reason_name' => 'Harassment']);
        $spam = ReportReason::create(['reason_name' => 'Spam']);
        $offensive_content = ReportReason::create(['reason_name' => 'Offensive Content']);
        $impersonation = ReportReason::create(['reason_name' => 'Impersonation']);
        $fraud = ReportReason::create(['reason_name' => 'Fraud']);
        $csam = ReportReason::create(['reason_name' => 'Child Sexual Abuse Material (CSAM)']);
        $self_harm = ReportReason::create(['reason_name' => 'Self-Harm']);
        $hate_speech = ReportReason::create(['reason_name' => 'Hate Speech']);
        $violence_and_crime = ReportReason::create(['reason_name' => 'Violence and Criminal Behavior']);
        $nudity_and_sexual_content = ReportReason::create(['reason_name' => 'Nudity and Sexual Content']);
        $copyright_violation = ReportReason::create(['reason_name' => 'Copyright Violation']);
        $terrorism = ReportReason::create(['reason_name' => 'Terrorism']);
        $harassment_of_minors = ReportReason::create(['reason_name' => 'Harassment of Minors']);
        $misinformation = ReportReason::create(['reason_name' => 'Misinformation']);
        $privacy_violations = ReportReason::create(['reason_name' => 'Privacy Violations']);
        $unwanted_content = ReportReason::create(['reason_name' => 'Unwanted Content']);
        $unsolicited_contact = ReportReason::create(['reason_name' => 'Unsolicited Contact']);

        // Sub-reasons for "Harassment"
        $harassment->subReasons()->createMany([
            ['sub_reason_name' => 'Bullying'],
            ['sub_reason_name' => 'Verbal Abuse'],
            ['sub_reason_name' => 'Threats'],
            ['sub_reason_name' => 'Hate Speech'],
        ]);

        // Sub-reasons for "Spam"
        $spam->subReasons()->createMany([
            ['sub_reason_name' => 'Unwanted Messages'],
            ['sub_reason_name' => 'Fake Accounts'],
            ['sub_reason_name' => 'Advertising'],
            ['sub_reason_name' => 'Phishing'],
        ]);

        // Sub-reasons for "Offensive Content"
        $offensive_content->subReasons()->createMany([
            ['sub_reason_name' => 'Graphic Content'],
            ['sub_reason_name' => 'Nudity'],
            ['sub_reason_name' => 'Explicit Language'],
            ['sub_reason_name' => 'Violence'],
            ['sub_reason_name' => 'Inappropriate Content'],
        ]);

        // Sub-reasons for "Impersonation"
        $impersonation->subReasons()->createMany([
            ['sub_reason_name' => 'Fake Profile'],
            ['sub_reason_name' => 'Using Someone Else’s Identity'],
            ['sub_reason_name' => 'Misleading Name/Username'],
        ]);

        // Sub-reasons for "Fraud"
        $fraud->subReasons()->createMany([
            ['sub_reason_name' => 'Scams'],
            ['sub_reason_name' => 'Fake Promotions'],
            ['sub_reason_name' => 'Fraudulent Activities'],
        ]);

        // Sub-reasons for "CSAM"
        $csam->subReasons()->createMany([
            ['sub_reason_name' => 'Explicit Content Involving Minors'],
        ]);

        // Sub-reasons for "Self-Harm"
        $self_harm->subReasons()->createMany([
            ['sub_reason_name' => 'Promoting Self-Harm'],
            ['sub_reason_name' => 'Suicide Threats'],
            ['sub_reason_name' => 'Encouraging Harmful Behavior'],
        ]);

        // Sub-reasons for "Hate Speech"
        $hate_speech->subReasons()->createMany([
            ['sub_reason_name' => 'Racism'],
            ['sub_reason_name' => 'Religious Intolerance'],
            ['sub_reason_name' => 'Homophobia'],
            ['sub_reason_name' => 'Xenophobia'],
        ]);

        // Sub-reasons for "Violence and Criminal Behavior"
        $violence_and_crime->subReasons()->createMany([
            ['sub_reason_name' => 'Threatening Behavior'],
            ['sub_reason_name' => 'Physical Assault or Violence'],
            ['sub_reason_name' => 'Criminal Activities'],
        ]);

        // Sub-reasons for "Nudity and Sexual Content"
        $nudity_and_sexual_content->subReasons()->createMany([
            ['sub_reason_name' => 'Explicit Content'],
            ['sub_reason_name' => 'Adult Content'],
            ['sub_reason_name' => 'Sexually Suggestive Behavior'],
        ]);

        // Sub-reasons for "Copyright Violation"
        $copyright_violation->subReasons()->createMany([
            ['sub_reason_name' => 'Use of Protected Material Without Permission'],
            ['sub_reason_name' => 'Piracy'],
            ['sub_reason_name' => 'Sharing Illegal Content'],
        ]);

        // Sub-reasons for "Terrorism"
        $terrorism->subReasons()->createMany([
            ['sub_reason_name' => 'Promoting Terrorism or Violence'],
            ['sub_reason_name' => 'Inciting Hate or Harm'],
            ['sub_reason_name' => 'Extremist Content'],
        ]);

        // Sub-reasons for "Harassment of Minors"
        $harassment_of_minors->subReasons()->createMany([
            ['sub_reason_name' => 'Grooming'],
            ['sub_reason_name' => 'Sexual Harassment'],
            ['sub_reason_name' => 'Inappropriate Behavior Towards Minors'],
        ]);

        // Sub-reasons for "Misinformation"
        $misinformation->subReasons()->createMany([
            ['sub_reason_name' => 'Fake News'],
            ['sub_reason_name' => 'Hoaxes'],
            ['sub_reason_name' => 'Unverified Claims'],
        ]);

        // Sub-reasons for "Privacy Violations"
        $privacy_violations->subReasons()->createMany([
            ['sub_reason_name' => 'Sharing Personal Information Without Consent'],
            ['sub_reason_name' => 'Doxxing'],
            ['sub_reason_name' => 'Breach of Privacy'],
        ]);

        // Sub-reasons for "Unwanted Content"
        $unwanted_content->subReasons()->createMany([
            ['sub_reason_name' => 'Offensive Images'],
            ['sub_reason_name' => 'Unsolicited Advertising'],
            ['sub_reason_name' => 'Fake News'],
        ]);

        // Sub-reasons for "Unsolicited Contact"
        $unsolicited_contact->subReasons()->createMany([
            ['sub_reason_name' => 'Spam Messages'],
            ['sub_reason_name' => 'Harassment Through Messages'],
            ['sub_reason_name' => 'Stalking'],
        ]);
    }
}
