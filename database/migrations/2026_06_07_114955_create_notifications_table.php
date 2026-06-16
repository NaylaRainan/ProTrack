public function up(): void
{
    Schema::create('notifications', function (Blueprint $table) {

        $table->id();

        $table->foreignId('spk_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

        $table->string('title');

        $table->text('message');

        $table->boolean('is_read')
            ->default(false);

        $table->timestamps();
    });
}